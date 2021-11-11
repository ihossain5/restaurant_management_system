<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Order;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ManagerOrderPerformanceController extends Controller {
    public $order;
    public $orderService;

    public function __construct(Order $order, OrderService $orderService) {
        $this->order        = $order;
        $this->orderService = $orderService;
    }

    public function dailyReports(Request $request) {
        $restaurant = Auth::user()->restaurant;
        $orders     = $this->order->todayOrdersByRestaurantId($restaurant->restaurant_id);
        foreach ($orders as $order) {
            $order['start_date']   = formatDate(Carbon::now());
            $order['total_order']  = count($orders);
            $order['total_amount'] = $orders->sum('amount');
        }
        if ($request->ajax()) {
            return $this->dailySalesDataTable($orders);
        }
        return view('manager.performance-report.daily_orders_report', );
    }
    public function dailyReportsByDate(Request $request) {
        $date       = Carbon::parse($request->date)->format('Y-m-d');
        $restaurant = Auth::user()->restaurant;
        $orders     = $this->order->ordersByDate($date, $restaurant->restaurant_id);

        foreach ($orders as $order) {
            $order['start_date']   = formatDate($request->date);
            $order['total_order']  = count($orders);
            $order['total_amount'] = $orders->sum('amount');
        }
        return $this->dailySalesDataTable($orders);
    }
    public function itemPerformanceReport(Request $request) {
        $items = Item::withSum(['orders' => function ($query) {
            $query->whereDate('orders.created_at', '=', Carbon::now())
                ->where('orders.restaurant_id', auth()->user()->restaurant->restaurant_id)
                ->where('orders.order_status_id', 3);
        }], 'amount')->withCount(['orders' => function ($query) {
            $query->whereDate('orders.created_at', '=', Carbon::now())
                ->where('orders.restaurant_id', auth()->user()->restaurant->restaurant_id)
                ->where('orders.order_status_id', 3);
        }])->with('today_completed_orders', 'category')->orderBy('orders_count', 'DESC')
            ->get();

        $newItems = [];
        $total    = 0;
        foreach ($items as $item) {
            if ($item->orders_count != 0) {
                $total += $item->today_completed_orders->sum('pivot.price');
                $newItems[] = $item;

            }
        }
        foreach ($newItems as $data) {
            $data['total_amount'] = $total;
        }

        // dd($newItems);
        $restaurant = Auth::user()->restaurant;
        $categories = $restaurant->restaurant_categories;
        $orders     = $this->order->todayOrdersByRestaurantId($restaurant->restaurant_id);
        $date       = formatDate(Carbon::today());
        // dd($date);
        $items = $this->getOrderItems($orders, $date, $date);
        if ($request->ajax()) {
            return $this->itemPerformanceDataTable(collect($newItems));
        }
        return view('manager.performance-report.item_performance_report', compact('date', 'categories', 'total'));
    }

    public function itemPerformanceReportByDate(Request $request) {
        // dd($request->all());
        $category_id = $request->id;
        $start_date  = $request->start_date;
        $end_date    = $request->end_date;
        if ($category_id == null &&  $start_date != null || $end_date != null )  {
            dd('fffffffff');
            $items = $this->getItemsByOrder($this->totdayCompletedOrders());
            return $this->itemPerformanceDataTable(collect($items));
        } else if ($category_id != null) {
            if ($start_date == null && $end_date == null) {
                dd('ssssssss');
                $items    = $this->totdayCompletedOrders();
                $newItems = [];
                foreach ($items as $item) {
                    if ($item->category_id == $category_id) {
                        $newItems[] = $item;
                    }
                }
                return $this->itemPerformanceDataTable(collect($this->getItemsByOrder($newItems)));
            } else {
                dd('asdasd');
                // $format_start_date = Carbon::parse($start_date)->format('y-m-d');
                // $format_end_date   = Carbon::parse($end_date)->format('y-m-d');
                // $items = $this->getCompletedOrderItemsByDateRange($format_start_date, $format_end_date);
                // $newItems = [];
                // $total    = 0;
                // foreach ($items as $item) {
                //         if ($item->orders_count != 0) {
                //             if ($item->category_id == $category_id) {
                //             $total += $this->completedOrdersByDateRange($format_start_date,$format_end_date)->sum('pivot.price');
                //             $newItems[] = $item;
                //         }
                //     }
                
                // }
                // // dd($total);
                // foreach ($newItems as $data) {
                //     $data['total_amount'] = $total;
                // }

                // return $this->itemPerformanceDataTable(collect($items));
            }
        }
        // $start_date = Carbon::parse($request->start_date)->format('y-m-d');
        // $end_date   = Carbon::parse($request->end_date)->format('y-m-d');
        // if ($request->id == null) {
        //     $restaurant = Auth::user()->restaurant;
        //     return $this->performanceReportByDate($start_date, $end_date, $restaurant->restaurant_id);
        // }
        // $category = Category::findOrFail($request->id);
        // $orders   = $this->order->getOrdersByDate($start_date, $end_date, $category->restaurant_id);
        // $items    = [];
        // $total = 0;
        // foreach ($orders as $order) {
        //     foreach ($order->items as $item) {
        //         if ($item->category_id == $request->id) {
        //             $items[]              = $item;
        //             $item['start_date']   = formatDate($request->start_date);
        //             $item['end_date']     = formatDate($request->end_date);
        //             $item['total_order']  = count($item->orders);
        //             $total += $item->pivot->price;
        //         }
        //         $item['total_amount'] = $total;
        //     }
        // }
        // // dd($total);
        // return $this->itemPerformanceDataTable(collect($items));
        $restaurant = Auth::user()->restaurant;
        if ($request->start_date != null && $request->end_date != null && $request->id != null) {
// dd('not null');
            $start_date = Carbon::parse($request->start_date)->format('y-m-d');
            $end_date   = Carbon::parse($request->end_date)->format('y-m-d');
            $orders     = $this->orderService->getCompletedOrdersByDateRange($start_date, $end_date, $restaurant->restaurant_id);
            $items      = [];
            $total      = 0;
            foreach ($orders as $order) {
                foreach ($order->items as $item) {
                    if ($item->category_id == $request->id) {
                        $items[]             = $item;
                        $item['start_date']  = formatDate($request->start_date);
                        $item['end_date']    = formatDate($request->end_date);
                        $item['total_order'] = count($orders);
                        $total += $item->pivot->price;
                        $item['revenue'] = $item->pivot->price;
                    }
                    $item['total_amount'] = $total;
                    // $item['total_order'] = $total_order;
                }
            }

        }
        // else if ($request->id != null) {
        //     // dd('sdasd');
        //     $start_date = Carbon::parse($request->start_date)->format('y-m-d');
        //     $end_date   = Carbon::parse($request->end_date)->format('y-m-d');
        //     $orders     = $this->orderService->lastMonthCompletedOrders($restaurant->restaurant_id);
        //     $items      = [];
        //     $total      = 0;
        //     foreach ($orders as $order) {
        //         foreach ($order->items as $item) {
        //             if ($item->category_id == $request->id) {
        //                 $items[]                = $item;
        //                 $item['total_quantity'] = $item->pivot->quantity;
        //                 $item['revenue']        = $item->pivot->price;
        //                 $item['start_date']     = formatDate($request->start_date);
        //                 $item['end_date']       = formatDate($request->end_date);
        //                 $total += $item->pivot->price;
        //                 $item['total_order']  = count($orders);
        //                 $item['sdsd']         = $total;
        //                 $item['total_amount'] = $order->items->sum('pivot.price');
        //             }
        //         }

        //     }
        //     // $category = Category::findOrFail($request->id);
        //     // // $orders     = $restaurant->lastMontCompletedOrders($restaurant->restaurant_id);
        //     // $orders = $this->order->todayOrdersByRestaurantId($restaurant->restaurant_id);

        //     // $items = [];
        //     // $total = 0;
        //     // foreach ($orders as $order) {
        //     //     foreach ($order->items as $item) {
        //     //         if ($item->category_id == $request->id) {
        //     //             $items[]             = $item;
        //     //             $item['start_date']  = formatDate($request->start_date);
        //     //             $item['end_date']    = formatDate($request->end_date);
        //     //             $item['total_order'] = count($orders);
        //     //             $total += $item->pivot->price;
        //     //             $item['revenue'] = $item->pivot->price;
        //     //         }
        //     //         $item['total_amount'] = $total;
        //     //         // $item['total_order'] = $total_order;
        //     //     }
        //     // }
        // } else if ($request->end_date != null && $request->end_date != null) {
        //     // dd($request->all());
        //     $start_date = Carbon::parse($request->start_date)->format('y-m-d');
        //     $end_date   = Carbon::parse($request->end_date)->format('y-m-d');
        //     $orders     = $this->orderService->getCompletedOrdersByDateRange($start_date, $end_date, $restaurant->restaurant_id);
        //     $items      = [];
        //     $total      = 0;
        //     foreach ($orders as $order) {
        //         foreach ($order->items as $item) {
        //             $items[]                = $item;
        //             $item['total_quantity'] = $item->pivot->quantity;
        //             $item['revenue']        = $item->pivot->price;
        //             $item['start_date']     = formatDate($request->start_date);
        //             $item['end_date']       = formatDate($request->end_date);
        //             $total += $item->pivot->price;
        //             $item['total_order']  = count($order->items);
        //             $item['total_amount'] = $order->items->sum('pivot.price');
        //         }
        //     }

        // }
        else {
            $orders = $this->order->todayOrdersByRestaurantId($restaurant->restaurant_id);
            $items  = [];
            $total  = 0;
            foreach ($orders as $order) {
                foreach ($order->items as $item) {
                    $items[]                = $item;
                    $item['total_quantity'] = $item->pivot->quantity;
                    $item['revenue']        = $item->pivot->price;
                    $item['start_date']     = formatDate($request->start_date);
                    $item['end_date']       = formatDate($request->end_date);
                    $total += $item->pivot->price;
                    $item['total_order']  = count($orders);
                    $item['total_amount'] = $order->items->sum('pivot.price');
                }
            }
        }

        return DataTables::of($items)
            ->addIndexColumn()
            ->make(true);
    }

    public function performanceReportByDate($start_date, $end_date, $restaurant) {
        $orders = $this->order->getOrdersByDate($start_date, $end_date, $restaurant);
        $items  = $this->getOrderItems($orders, $start_date, $end_date);
        return $this->itemPerformanceDataTable(collect($items));
    }

    public function itemPerformanceReportByRestaurant(){
        $restaurant = Auth::user()->restaurant;
        $categories = $restaurant->restaurant_categories;
        return view('manager.performance-report.item_performance_report_new');
    }

    public function getOrderItems($orders, $start_date, $end_date) {
        $items = [];
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $items[]              = $item;
                $item['start_date']   = $start_date;
                $item['end_date']     = $end_date;
                $item['total_order']  = count($orders);
                $item['total_amount'] = $order->items->sum('pivot.price');
            }
        }
        return $items;
    }

    public function dailySalesDataTable($ordersData) {
        return DataTables::of($ordersData)
            ->addIndexColumn()
            ->addColumn('time', function ($data) {
                $time = Carbon::parse($data->created_at)->format('g:i A');
                return $time;
            })
            ->make(true);
    }
    // public function itemPerformanceDataTable($ordersData) {
    //     return DataTables::of($ordersData)
    //         ->addIndexColumn()
    //         ->addColumn('revenue', function ($data) {
    //             $revenue = $data->pivot->price;;
    //             return $revenue;
    //         })
    //         ->make(true);
    // }
    public function itemPerformanceDataTable($ordersData) {
        return DataTables::of($ordersData)
            ->addIndexColumn()
            ->addColumn('revenue', function ($data) {
                return $data->today_completed_orders->sum('pivot.price');
            })
            ->addColumn('quantity', function ($data) {
                return $data->today_completed_orders->sum('pivot.quantity');
            })
            ->make(true);
    }

    protected function totdayCompletedOrders() {
        $items = Item::withCount(['orders' => function ($query) {
            $query->whereDate('orders.created_at', '=', Carbon::now())
                ->where('orders.restaurant_id', auth()->user()->restaurant->restaurant_id)
                ->where('orders.order_status_id', 3);
        }])->with('today_completed_orders', 'category')->orderBy('orders_count', 'DESC')
            ->get();
        return $items;
    }

    protected function getItemsByOrder($items) {
        $newItems = [];
        $total    = 0;
        foreach ($items as $item) {
            if ($item->orders_count != 0) {
                $total += $item->today_completed_orders->sum('pivot.price');
                $newItems[] = $item;
            }
        }
        foreach ($newItems as $data) {
            $data['total_amount'] = $total;
        }
        return $newItems;
    }

    public function getCompletedOrderItemsByDateRange($start_date, $end_date) {
        return Item::withCount(['orders' => function ($query) use($start_date, $end_date) {
            $query->whereDate('orders.created_at', '>=', $start_date)
                ->whereDate('orders.created_at', '<=', $end_date)
                ->where('orders.restaurant_id', auth()->user()->restaurant->restaurant_id)
                ->where('orders.order_status_id', 3);
        }])->with('category')->orderBy('orders_count', 'DESC')
            ->get();

    }
    public function completedOrdersByDateRange($start_date, $end_date) {
        return Order::whereDate('orders.created_at', '>=', $start_date)
        ->whereDate('orders.created_at', '<=', $end_date)
        ->where('orders.restaurant_id', auth()->user()->restaurant->restaurant_id)
        ->where('orders.order_status_id', 3)->get();

    }
}
