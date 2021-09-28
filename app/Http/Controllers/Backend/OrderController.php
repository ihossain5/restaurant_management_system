<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DataTables;

class OrderController extends Controller {
    public function getTodayOrders($id) {
        $restaurant  = $this->todayOrdersByRestaurant($id);
        $restaurants = Restaurant::get();
        // return view('admin.order-management.today_orders', compact('restaurants', 'restaurant'));
        return view('admin.order-management.today_orders_new', compact('restaurants', 'restaurant'));
    }

    public function todayOrders(Request $request,$id){
        $restaurant  = $this->todayOrdersByRestaurant($id);
        return $this->dataTable($restaurant->restaurant_orders, $request);
    }

    public function pastOrders(Request $request,$id){
        $restaurant  = $this->pastOrdersByRestaurant($id);
        return $this->dataTable($restaurant->restaurant_orders, $request);
    }

    public function getPastOrders($id) {
        $restaurant = Restaurant::with(['restaurant_orders' => function ($query) {
            $query->whereDate('orders.created_at', '!=', Carbon::today())->get();
        }])->find($id);
        $restaurants = Restaurant::get();
        return view('admin.order-management.past_orders_new', compact('restaurants', 'restaurant'));
        // return view('admin.order-management.past_orders', compact('restaurants', 'restaurant'));
    }

    public function show(Request $request) {
        $order = Order::with('items', 'status', 'customer')->findOrFail($request->id);
        $class = (($order->status->name == 'Preparing') ? 'txt-preparing'
            : (($order->status->name == 'Delivering') ? 'txt-delivering' : (($order->status->name == 'Completed') ? 'txt-completed' : 'txt-cancelled')));
        $order['class'] = $class;
        return success($order);
    }

    public function getOrdersByRestaurant(Request $request) {
        $restaurant = $this->todayOrdersByRestaurant($request->id);
        setSession($request->id);
        $data                    = [];
        $data['id']              = $request->id;
        $data['session_id']      = Session::get('restaurant_id');
        $data['orders']          = $restaurant->restaurant_orders;
        $data['restaurant_name'] = $restaurant->name;
        return success($data);
    }

    public function getPastOrdersByRestaurant(Request $request) {
        $restaurant = $this->pastOrdersByRestaurant($request->id);
        // dd($restaurant->restaurant_orders);
        setSession($request->id);
        $data                    = [];
        foreach($restaurant->restaurant_orders as $order){
            $data['date'] = formatDate($order->created_at);
        }
     
        $data['id']              = $request->id;
        $data['restaurant_name'] = $restaurant->name;
        $data['session_id']      = Session::get('restaurant_id');
        $data['orders']          = $restaurant->restaurant_orders;
        return success($data);
    }

    public function todayOrdersByRestaurant($restaurant_id) {
        return Restaurant::with(['restaurant_orders' => function ($query) {
            $query->whereDate('orders.created_at', Carbon::today())->get();
        }])->find($restaurant_id);
    }
    public function pastOrdersByRestaurant($restaurant_id) {
        return Restaurant::with(['restaurant_orders' => function ($query) {
            $query->whereDate('orders.created_at', '!=', Carbon::today())->get();
        }])->find($restaurant_id);
    }

    public function getAllOrders(Request $request){
        if ($request->ajax()) {
            $data = User::get();
            // dd($data);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)"  class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function orders(){
        return view('admin.order-management.all_orders');
    }


    public function dataTable($restaurant_orders,$request){
        foreach($restaurant_orders as $order){
            $order->date = formatDate($order->created_at);
            $customer_name =  $order->is_default_name == 0 ? $order->name : $order->customer->name;
            $order->customer_name = $customer_name;
            $customer_contact =  $order->is_default_contact == 0 ? $order->contact : $order->customer->contact;
            $order->customer_contact = $customer_contact;
            $customer_address =  $order->is_default_address == 0 ? $order->address : $order->customer->address ;
            $order->customer_address = $customer_address;
        }
        if ($request->ajax()) {
            // dd($data);
            return DataTables::of($restaurant_orders)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = "<button type='button' class='btn btn-outline-dark' onclick='viewOrder($data->order_id)'>
                    <i class='fa fa-eye'></i>
                </button>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    
}
