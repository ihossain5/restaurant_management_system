<?php

namespace App\Services;

use App\Models\Order;
use Carbon\Carbon;

class OrderService {
    /* find order by id*/
    public function findOrderById($id) {
        $order             = Order::with('items', 'status', 'customer', 'order_combos')->findOrFail($id);
        $order->orderItems = $this->orderItems($order);
        $order->sutTotal   = $this->getOrderSubTotal($id);
        return $order;
    }

    // get all past order by restaurant
    public function pastOrders($restaurant_id) {
        return Order::with('customer', 'status')->where('restaurant_id', $restaurant_id)->whereDate('created_at', '!=', Carbon::today())->latest();
    }
    // get all today's order by restaurant
    public function todaysOrders($restaurant_id) {
        return Order::with('customer', 'status')->where('restaurant_id', $restaurant_id)->whereDate('created_at', '=', Carbon::today())->get();
    }

    /**
     * Get orders by date
     */
    public function getOrdersByDate($date, $restaurant_id) {
        return Order::with('customer', 'status')->where('restaurant_id', $restaurant_id)
            ->whereDate('created_at', $date)->get();
    }

    /**
     * Get orders by date range
     */
    public function getOrdersByDateRange($start_date, $end_date, $restaurant_id) {
        return Order::with('customer', 'status')->where('restaurant_id', $restaurant_id)
            ->whereDate('orders.created_at', '>=', $start_date)
            ->whereDate('orders.created_at', '<=', $end_date)
            ->get();
    }
    /**
     * Get completed orders by date range
     */
    public function getCompletedOrdersByDateRange($start_date, $end_date, $restaurant_id) {
        return Order::with('customer', 'status', 'items.category')->where('restaurant_id', $restaurant_id)
            ->whereDate('orders.created_at', '>=', $start_date)
            ->whereDate('orders.created_at', '<=', $end_date)
            ->where('order_status_id', '=', 3)
            ->get();
    }
    /**
     * Get orders by month and year
     */
    public function getOrdersByMonth($month, $year, $restaurant_id) {
        return Order::with('customer', 'status')->where('restaurant_id', $restaurant_id)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
    }
    /**
     * Get last month completed orders
     */
    public function lastMonthCompletedOrders($restaurant_id) {
        return Order::with('customer', 'status','items','items.category')->where('restaurant_id', $restaurant_id)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', now()->year)
            ->where('order_status_id', '=', 3)
            ->get();
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

    public function getOrderSubTotal($id) {
        $order    = Order::findOrFail($id);
        $subtotal = $order->amount - $order->delivery_fee - $order->vat_amount;
        return $subtotal;
    }

    //get number of orders
    public function numberOfOrders($orders) {
        return $orders->count();
    }
    //get total amount of orders
    public function totalAmountOfOrders($orders) {
        return $orders->sum('amount');
    }


}