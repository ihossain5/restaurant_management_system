<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller {
    public function getTodayOrders($id) {
        $new_restaurant = Restaurant::with('restaurant_items.orders')->find($id);
        // $new_restaurant = Restaurant::find($id);
        $restaurants = Restaurant::get();
        $all_orders  = $this->ordersByRestaurant($new_restaurant);

        // $orders = Order::whereDate('created_at', DB::raw('CURDATE()'))->get();
        return view('admin.order-management.orders', compact('restaurants', 'new_restaurant', 'all_orders'));

    }
    public function getPastOrders() {
        $orders = Order::whereDate('created_at', '!=', DB::raw('CURDATE()'))->get();
        dd($orders);
    }

 

    public function show(Request $request) {
        $order = Order::with('items', 'status', 'customer')->findOrFail($request->id);
        $class = (($order->status->name == 'Preparing') ? 'txt-preparing'
            : (($order->status->name == 'Delivering') ? 'txt-delivering' : (($order->status->name == 'Completed') ? 'txt-completed' : 'txt-cancelled')));
         $order['class']=$class;   
        return success($order);
    }

    public function getOrdersByRestaurant(Request $request){
        $restaurant = Restaurant::findOrFail($request->id);
        if (Session::has('restaurant_id')) {
            Session::forget('restaurant_id');
        }
        Session::put('restaurant_id', $request->id);
        $orders = $this->ordersByRestaurant($restaurant);
        $data            = [];
        $data['id']      = $request->id;
        $data['session_id'] = Session::get('restaurant_id');
        $data['all_orders']      = $orders;
        return success($data);
    }

    public function ordersByRestaurant($restaurant) {
        $orders = [];
        foreach ($restaurant->restaurant_items as $item) {
            $orders[] = $item->orders;
        }
        return $orders;
    }
}
