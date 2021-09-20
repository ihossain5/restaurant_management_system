<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller {
    public function getTodayOrders($id) {
        $restaurant = Restaurant::with(['restaurant_items.orders' => function ($query)  {
            $query->whereDate('orders.created_at', DB::raw('CURDATE()'))->get();
        }])->find($id);
        $all_orders  = $this->ordersByRestaurant($restaurant);
        $restaurants = Restaurant::get();

        // $orders = Order::whereDate('created_at', DB::raw('CURDATE()'))->get();
        return view('admin.order-management.today_orders', compact('restaurants', 'restaurant', 'all_orders'));

    }
    public function getPastOrders($id) {
        $restaurant = Restaurant::with(['restaurant_items.orders' => function ($query)  {
            $query->whereDate('orders.created_at', '!=', DB::raw('CURDATE()'))->get();
        }])->find($id);
        $all_orders  = $this->ordersByRestaurant($restaurant);
        // dd($all_orders);
        $restaurants = Restaurant::get();
        return view('admin.order-management.past_orders', compact('restaurants', 'restaurant', 'all_orders'));
    }

 

    public function show(Request $request) {
        $order = Order::with('items', 'status', 'customer')->findOrFail($request->id);
        $class = (($order->status->name == 'Preparing') ? 'txt-preparing'
            : (($order->status->name == 'Delivering') ? 'txt-delivering' : (($order->status->name == 'Completed') ? 'txt-completed' : 'txt-cancelled')));
         $order['class']=$class;   
        return success($order);
    }

    public function getOrdersByRestaurant(Request $request){
        $restaurant = Restaurant::with(['restaurant_items.orders' => function ($query)  {
            $query->whereDate('orders.created_at', DB::raw('CURDATE()'))->get();
        }])->find($request->id);

        if (Session::has('restaurant_id')) {
            Session::forget('restaurant_id');
        }
        Session::put('restaurant_id', $request->id);
        $orders = $this->ordersByRestaurant($restaurant);
        $data            = [];
        $data['id']      = $request->id;
        $data['session_id'] = Session::get('restaurant_id');
        $data['orders']      = $orders;
        return success($data);
    }

    public function getPastOrdersByRestaurant(Request $request){
        $restaurant = Restaurant::with(['restaurant_items.orders' => function ($query)  {
            $query->whereDate('orders.created_at', '!=', DB::raw('CURDATE()'))->get();
        }])->find($request->id);

        if (Session::has('restaurant_id')) {
            Session::forget('restaurant_id');
        }
        Session::put('restaurant_id', $request->id);
        $orders = $this->ordersByRestaurant($restaurant);
        $data            = [];
        $data['id']      = $request->id;
        $data['session_id'] = Session::get('restaurant_id');
        $data['orders']      = $orders;
        return success($data);
    }

    public function ordersByRestaurant($restaurant) {
        foreach ($restaurant->restaurant_items as $item) {
            $restaurant->all_orders = $item->orders;
        }
        return $restaurant;
    }
}
