<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Restaurant;
use App\Services\OrderService;
use App\Services\RestaurantService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class OrderPerformanceController extends Controller {
    public $orderService;
    public $restaurantService;

    public function __construct(OrderService $orderService, RestaurantService $restaurantService) {
        $this->orderService      = $orderService;
        $this->restaurantService = $restaurantService;
    }

    public function dailyReports(Request $request, $id) {
        $restaurant        = $this->restaurantService->findById($id);
        $restaurants       = $this->restaurantService->all();
        $current_date      = formatDate(Carbon::today());
        $orders            = $this->orderService->todaysOrders($id);
        $total_order       = $this->orderService->numberOfOrders($orders);
        $total_orderAmount = $this->orderService->totalAmountOfOrders($orders);
        if ($request->ajax()) {
            return $this->dataTable($orders);
        }
        // return view('admin.performance-reports.daily_report', compact('restaurant', 'restaurants', 'current_date'));
        return view('admin.performance-reports.daily_report_new', compact('restaurant', 'restaurants', 'current_date', 'total_orderAmount', 'total_order'));
    }

    public function dailyOrderReportsByRestaurant() {
        $orders = Session::get('orders');
        return $this->dataTable($orders);
    }

    public function dateWiseReportByRestaurant(Request $request, OrderService $orderService) {
        // dd($request->all());
        $date       = Carbon::parse($request->date)->format('y-m-d');
        $restaurant = $this->restaurantService->findById($request->id);
        $orders     = $orderService->getOrdersByDate($date, $request->id);
        setSession($request->id);
        // if (!empty($restaurant->restaurant_orders)) {
        //     foreach ($restaurant->restaurant_orders as $order) {
        //         $order->date = formatDate($order->created_at);
        //     }
        // }
        Session::put('orders', $orders);
        $data                    = [];
        $data['id']              = $request->id;
        $data['orders']          = $orders;
        $data['restaurant_name'] = $restaurant->name;
        $data['total_order']     = $this->orderService->numberOfOrders($orders);
        $data['total_amount']    = $this->orderService->totalAmountOfOrders($orders);
        $data['current_date']    = formatDate($request->date);
        $data['session_id']      = Session::get('restaurant_id');
        return success($data);
    }

    //reports by time range start
    public function timeRangeReports(Request $request, $id) {
        // dd($request->all());
        if ($request->start_date != null && $request->end_date != null) {
            $start_date = Carbon::parse($request->start_date)->format('y-m-d');
            $end_date   = Carbon::parse($request->end_date)->format('y-m-d');
            $orders     = $this->orderService->getOrdersByDateRange($start_date, $end_date, $id);
        } else {
            $orders = $this->orderService->todaysOrders($id);
        }
        $total_order       = $this->orderService->numberOfOrders($orders);
        $total_orderAmount = $this->orderService->totalAmountOfOrders($orders);
        $restaurants       = $this->restaurantService->all();
        $restaurant        = $this->restaurantService->findById($id);
        if ($request->ajax()) {
            return $this->dataTable($orders);
        }

        // return view('admin.performance-reports.time_range_report', compact('restaurant', 'restaurants'));
        return view('admin.performance-reports.time_range_report_new', compact('restaurant', 'restaurants', 'total_order', 'total_orderAmount'));

        // dd($restaurant);
    }
    public function timeRangeReportsByRestaurant(Request $request) {
        // if($request->start_date != null && $request->end_date != null){
        $start_date = Carbon::parse($request->start_date)->format('y-m-d');
        $end_date   = Carbon::parse($request->end_date)->format('y-m-d');
        $restaurant = $this->restaurantService->findById($request->id);
        $orders     = $this->orderService->getOrdersByDateRange($start_date, $end_date, $request->id);
        setSession($request->id);
        Session::put('orders', $orders);
        $data                    = [];
        $data['id']              = $request->id;
        $data['restaurant_name'] = $restaurant->name;
        $data['orders']          = $orders;
        $data['total_order']     = $this->orderService->numberOfOrders($orders);
        $data['total_amount']    = $this->orderService->totalAmountOfOrders($orders);
        $data['start_date']      = formatDate($request->start_date);
        $data['end_date']        = formatDate($request->end_date);
        $data['session_id']      = Session::get('restaurant_id');
        return success($data);
    } // reports by time range end

//monthly reports start
    public function currentMonthReportsByRestaurant(Request $request, $id) {
        $month              = date('m');
        $year               = date('Y');
        $current_month_name = Carbon::now()->format('F');
        $orders             = $this->orderService->getOrdersByMonth($month, $year, $id);
        $restaurants        = $this->restaurantService->all();
        $restaurant         = $this->restaurantService->findById($id);
        $total_order        = $this->orderService->numberOfOrders($orders);
        $total_amount       = $this->orderService->totalAmountOfOrders($orders);
        if ($request->ajax()) {
            return $this->dataTable($orders);
        }

        // return view('admin.performance-reports.monthly_report', compact('restaurant', 'restaurants', 'year', 'current_month_name', 'total_order', 'total_amount'));
        return view('admin.performance-reports.monthly_report_new', compact('restaurant', 'restaurants', 'year', 'current_month_name', 'total_order', 'total_amount'));
    }

    public function monthlyOrdersReportByRestaurant(Request $request) {
        $date       = explode('-', $request->date);
        $month      = str_replace(' ', ' ', $date[0]);
        $year       = $date[1];
        $orders     = $this->orderService->getOrdersByMonth($month, $year, $request->id);
        $restaurant = $this->restaurantService->findById($request->id);
        setSession($request->id);
        Session::put('orders', $restaurant->restaurant_orders);
        $formated_date           = Carbon::createFromDate($year, $month, 1);
        $data                    = [];
        $data['id']              = $request->id;
        $data['restaurant_name'] = $restaurant->name;
        $data['orders']          = $orders;
        $data['total_order']     = $this->orderService->numberOfOrders($orders);
        $data['total_amount']    = $this->orderService->totalAmountOfOrders($orders);
        $data['month']           = Carbon::parse($formated_date)->format('F');
        $data['year']            = Carbon::parse($formated_date)->format('y');
        $data['session_id']      = Session::get('restaurant_id');
        return success($data);
    }
    // monthly report end
    public function itemReportsByRestaurant(Request $request, $id) {
        // dd($request->all());
        $restaurant   = Restaurant::with('restaurant_categories', 'restaurant_orders', 'restaurant_orders.items', 'restaurant_orders.items.category')->findOrFail($id);
        $restaurants  = Restaurant::get();
        $orders       = $restaurant->lastMontCompletedOrders($id);
        $total_order  = $orders ? $orders->count() : 0;
        $total_amount = $orders ? $orders->sum('amount') : 0;

        if ($request->ajax()) {
            $items = [];
            foreach ($orders as $order) {
                foreach ($order->items as $item) {
                    $items[]                = $item;
                    $item['total_quantity'] = $item->pivot->quantity;
                    $item['total_amount']   = $item->pivot->price;
                }
            }
            // dd($items);
            return DataTables::of($items)
                ->addIndexColumn()
                ->make(true);

        }
        // return view('admin.performance-reports.item_performance_report', compact('restaurant', 'restaurants', 'total_order', 'total_amount'));
        return view('admin.performance-reports.item_performance_report_new', compact('restaurant', 'restaurants', 'total_order', 'total_amount'));
    }
    public function itemReportsByDate(Request $request) {
        // dd($request->all());
        $start_date              = Carbon::parse($request->start_date)->format('y-m-d');
        $end_date                = Carbon::parse($request->end_date)->format('y-m-d');
        $restaurant              = Restaurant::getOrdersByDateRange($start_date, $end_date, $request->id);
        $data                    = [];
        $data['id']              = $request->id;
        $data['restaurant_name'] = $restaurant->name;
        $data['orders']          = $restaurant->restaurant_orders;
        $data['total_order']     = $restaurant->restaurant_orders ? $restaurant->restaurant_orders->count() : 0;
        $data['total_amount']    = $restaurant->restaurant_orders ? $restaurant->restaurant_orders->sum('amount') : 0;
        $data['start_date']      = formatDate($request->start_date);
        $data['end_date']        = formatDate($request->end_date);
        return success($data);
    }

    public function itemReportsByCategory(Request $request) {
        // dd($request->all());

        if ($request->start_date != null && $request->end_date != null && $request->id != null) {
            $start_date = Carbon::parse($request->start_date)->format('y-m-d');
            $end_date   = Carbon::parse($request->end_date)->format('y-m-d');
            $orders     = $this->orderService->getCompletedOrdersByDateRange($start_date, $end_date, $request->restaurantId);
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
            $restaurant = Restaurant::with('restaurant_categories', 'restaurant_orders', 'restaurant_orders.items', 'restaurant_orders.items.category')->findOrFail($request->restaurantId);
            $orders     = $restaurant->lastMontCompletedOrders($request->restaurantId);

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
            $restaurant = Restaurant::with('restaurant_categories', 'restaurant_orders', 'restaurant_orders.items', 'restaurant_orders.items.category')->findOrFail($request->restaurantId);
            $orders     = $restaurant->lastMontCompletedOrders($request->restaurantId);
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

    // public function dataTable($restaurant_orders) {
    //     foreach ($restaurant_orders as $order) {
    //         $order->date             = formatDate($order->created_at);
    //         $customer_name           = $order->is_default_name == 1 ? $order->name : $order->customer->name;
    //         $order->customer_name    = $customer_name;
    //         $customer_contact        = $order->is_default_contact == 1 ? $order->contact : $order->customer->contact;
    //         $order->customer_contact = $customer_contact;
    //         $customer_address        = $order->is_default_address == 1 ? $order->address : $order->customer->address;
    //         $order->customer_address = $customer_address;
    //     }
    //     // dd($data);
    //     return DataTables::of($restaurant_orders)
    //         ->addIndexColumn()
    //         ->make(true);
    // }
    public function dataTable($restaurant_orders) {
        // dd($data);
        return DataTables::of($restaurant_orders)
            ->addIndexColumn()
            ->addColumn('order_date', function ($data) {
                return formatDate($data->created_at);
            })
            ->addColumn('status', function ($data) {
                return $data->status == null ? 'pending' : $data->status->name;
            })
            ->addColumn('customer_name', function ($data) {
                $customer_name = $data->is_default_name == 1 ? $data->name : $data->customer->name;
                return $customer_name;
            })
            ->addColumn('customer_contact', function ($data) {
                $customer_contact = $data->is_default_contact == 1 ? $data->contact : $data->customer->contact;
                return $customer_contact;
            })
            ->addColumn('customer_adress', function ($data) {
                $customer_adress = $data->is_default_address == 1 ? $data->address : $data->customer->address;
                return $customer_adress;
            })
            ->addColumn('total', function ($data) {
                return currency_format($data->amount);
            })
            ->addColumn('action', function ($data) {
                $actionBtn = "<button type='button' class='btn btn-outline-dark' onclick='viewOrder($data->order_id)'>
                    <i class='fa fa-eye'></i>
                </button>";
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
