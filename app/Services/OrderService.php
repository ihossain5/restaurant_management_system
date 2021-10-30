<?php

namespace App\Services;

use App\Models\Order;

class OrderService {
    public function findOrderById($id) {
        $order             = Order::with('items', 'status', 'customer', 'order_combos')->findOrFail($id);
        $order->orderItems = $this->orderItems($order);
        $order->class      = $this->orderStatusClass($order);
        return $order;
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
}