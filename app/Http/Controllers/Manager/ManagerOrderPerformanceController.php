<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
        $this->order = $order;
        $this->orderService      = $orderService;
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
        $restaurant = Auth::user()->restaurant;
        $categories = $restaurant->restaurant_categories;
        $orders     = $this->order->todayOrdersByRestaurantId($restaurant->restaurant_id);
        $date       = formatDate(Carbon::today());
        // dd($date);
        $items = $this->getOrderItems($orders, $date, $date);
        if ($request->ajax()) {
            return $this->itemPerformanceDataTable(collect($items));
        }
        return view('manager.performance-report.item_performance_report', compact('date', 'categories'));
    }

    public function itemPerformanceReportByDate(Request $request) {
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

        } else if ($request->id != null) {
            // dd($request->all());
            $category   = Category::findOrFail($request->id);
            $orders     = $restaurant->lastMontCompletedOrders($restaurant->restaurant_id);

            $items = [];
            $total = 0;
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
        } else {
            $orders     = $restaurant->lastMontCompletedOrders($restaurant->restaurant_id);
            $items      = [];
            $total      = 0;
            foreach ($orders as $order) {
                foreach ($order->items as $item) {
                    $items[]                = $item;
                    $item['total_quantity'] = $item->pivot->quantity;
                    $item['revenue']        = $item->pivot->price;
                    $total += $item->pivot->price;
                    $item['total_order'] = count($orders);
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
    public function itemPerformanceDataTable($ordersData) {
        return DataTables::of($ordersData)
            ->addIndexColumn()
            ->addColumn('revenue', function ($data) {
                $revenue = $data->pivot->price;;
                return $revenue;
            })
            ->make(true);
    }
}
