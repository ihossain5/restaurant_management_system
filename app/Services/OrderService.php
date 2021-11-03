<?php

namespace App\Services;

use App\Models\Order;
use Carbon\Carbon;

class OrderService {
    // get order details
    public function findOrderById($id) {
        $order             = Order::with('items', 'status', 'customer', 'order_combos')->findOrFail($id);
        $order->orderItems = $this->orderItems($order);
        $order->class      = $this->orderStatusClass($order);
        return $order;
    }

    // get all past order by restaurant
    public function pastOrders($restaurant_id){
        return Order::with('customer','status')->where('restaurant_id',$restaurant_id)->whereDate('orders.created_at', '!=', Carbon::today())->latest();
    }
    // get all today's order by restaurant
    public function todaysOrders($restaurant_id){
        return Order::with('customer','status')->where('restaurant_id',$restaurant_id)->whereDate('orders.created_at', '=', Carbon::today())->latest();
    }

    protected function orderStatusClass($order) {
        if ($order->status != null) {
            $class = (($order->status->name == 'Preparing') ? 'txt-preparing'
                : (($order->status->name == 'Delivering') ? 'txt-delivering' : (($order->status->name == 'Completed') ? 'txt-completed' : 'txt-cancelled')));
            return $class;
        }
    }

    public function orderItems($order) {
        $orderItems = [];
        foreach ($order->order_combos as $combo) {
            $orderItems[] = $combo;
        }
        foreach ($order->items as $item) {
            $orderItems[] = $item;
        }
        return $orderItems;
    }

    public function getOrderSubTotal($id){
        $order = Order::findOrFail($id);
        $subtotal = $order->amount - $order->delivery_fee - $order->vat_amount;
        return currency_format($subtotal);
    }
}