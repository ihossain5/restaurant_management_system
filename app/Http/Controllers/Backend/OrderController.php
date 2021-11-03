<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Services\OrderService;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller {
    public $orderService;
    public function __construct(OrderService $orderService) {
        $this->orderService = $orderService;
    }

    public function getTodayOrders(Request $request,$id) {
        $restaurant  = Restaurant::findOrFail($id);
        $restaurants = Restaurant::get();
        if ($request->ajax()) {
            $orders = $this->orderService->todaysOrders($id);
            return $this->dataTable($orders);
        }
        return view('admin.order-management.today_orders_new', compact('restaurants', 'restaurant'));
    }
    
    public function getPastOrders(Request $request, $id) {
        $restaurant  = Restaurant::findOrFail($id);
        $restaurants = Restaurant::get();
        if ($request->ajax()) {
            $orders = $this->orderService->pastOrders($id);
            return $this->dataTable($orders);
        }
        return view('admin.order-management.past_orders_new', compact('restaurants', 'restaurant'));
    }

    public function show(Request $request, OrderService $orderService) {
        $order = $orderService->findOrderById($request->id);
        return success($order);
    }

    public function getOrdersByRestaurant(Request $request) {
        $restaurant  = Restaurant::findOrFail($request->id);
        $orders = $this->orderService->todaysOrders($request->id);
        setSession($request->id);
        $data                    = [];
        $data['id']              = $request->id;
        $data['session_id']      = Session::get('restaurant_id');
        $data['orders']          = $orders;
        $data['restaurant_name'] = $restaurant->name;
        return success($data);
    }

    public function getPastOrdersByRestaurant(Request $request) {
        // dd($request->all());
        $orders = $this->orderService->pastOrders($request->id);
        $restaurant  = Restaurant::findOrFail($request->id);
        setSession($request->id);
        $data = [];
        foreach ($orders as $order) {
            $data['date'] = formatDate($order->created_at);
        }
        $data['id']              = $request->id;
        $data['restaurant_name'] = $restaurant->name;
        $data['session_id']      = Session::get('restaurant_id');
        $data['orders']          = $orders;
        return success($data);
    }

    public function todayOrdersByRestaurant($restaurant_id) {
        return Restaurant::with(['restaurant_orders' => function ($query) {
            $query->whereDate('orders.created_at', Carbon::today())->get();
        }])->find($restaurant_id);
    }
    


    public function dataTable($restaurant_orders) {
        // dd($data);
        return DataTables::of($restaurant_orders)
            ->addIndexColumn()
            ->addColumn('status', function ($data) {
                return $data->status == null ? 'pending' : $data->status->name;
            })
            ->addColumn('order_date', function ($data) {
                return formatDate($data->created_at);
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
