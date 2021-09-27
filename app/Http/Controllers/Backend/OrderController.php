<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller {
    public function getTodayOrders($id) {
        $restaurant  = $this->todayOrdersByRestaurant($id);
        $restaurants = Restaurant::get();
        return view('admin.order-management.today_orders', compact('restaurants', 'restaurant'));
    }

    public function getPastOrders($id) {
        $restaurant = Restaurant::with(['restaurant_orders' => function ($query) {
            $query->whereDate('orders.created_at', '!=', Carbon::today())->get();
        }])->find($id);
        $restaurants = Restaurant::get();
        return view('admin.order-management.past_orders', compact('restaurants', 'restaurant'));
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
}
