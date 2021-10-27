<?php

namespace App\Services;

class OrderService{
    public function orderItems($order){
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