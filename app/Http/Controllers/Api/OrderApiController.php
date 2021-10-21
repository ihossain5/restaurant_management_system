<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Order;

class OrderApiController extends Controller {
    public function all() {
        $orders = Order::with('items', 'status', 'customer')->get();
        return response()->json([
            'status' => true,
            'data'   => $orders,
        ]);
    }
    public function getOrderById(Order $order) {
        $order->load('items', 'status', 'customer');
        $data                     = [];
        $data['order_id']         = $order->order_id;
        $data['customer_name']    = $order->is_default_name == 0 ? $order->name : $order->customer->name;
        $data['customer_contact'] = $order->is_default_contact == 0 ? $order->contact : $order->customer->contact;
        $data['customer_address'] = $order->is_default_address == 0 ? $order->address : $order->customer->address;
        $data['customer_address'] = $order->is_default_address == 0 ? $order->address : $order->customer->address;
        $data['email']            = $order->customer->email;
        $data['special_notes']    = $order->special_notes;
        $data['items']            = $order->items;

        return response()->json([
            'status' => true,
            'data'   => $data,
        ]);
    }
    public function getItemById(Item $item) {
        return response()->json([
            'status' => true,
            'data'   => $item,
        ]);
    }

    public function items(){
        return response()->json([
            'status' => true,
            'data'   => Item::all(),
        ]);
    }
}
