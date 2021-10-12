<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model {
    use HasFactory;
    protected $primaryKey = 'order_id';
    protected $fillable   = [
        'customer_id',
        'order_status_id',
        'id',
        'amount',
        'is_default_name',
        'name',
        'is_default_contact',
        'contact',
        'is_default_address',
        'address',
        'delivery_fee',
        'apology_note',
        'special_notes',
    ];
    public function items() {
        return $this->belongsToMany(Item::class, 'order_items', 'order_id', 'item_id')->withPivot('quantity', 'price')->withTimestamps();
    }
    public function order_items() {
        return $this->belongsToMany(Item::class, 'order_items', 'order_id', 'item_id')
            ->withPivot('quantity', 'price')->withTimestamps();
    }

    public function status() {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }
    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function restaurant() {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    public static function todayOrdersByRestaurantId($restaurant) {
        return Order::with('items', 'items.category')->where('restaurant_id', $restaurant)
            ->whereDate('orders.created_at', DB::raw('CURDATE()'))->with('customer')->get();
    }
    public function todaysRevenue() {
        return $this->whereDate('created_at', DB::raw('CURDATE()'))
            ->where('order_status_id', 3)
            ->sum('amount');
    }
    public function lastMonthOrders() {
        return $this->with('restaurant')->whereMonth(
            'created_at', '=', Carbon::now()->subMonth()->month
        )->where('order_status_id', 3)
            ->groupBy('restaurant_id')
            ->get([
                'restaurant_id',
                DB::raw("SUM(amount) as total_amount"),
                DB::raw("COUNT(order_status_id) as completed"),
            ]);
    }
    public function todayOrdersInPreparationByRestaurantId($restaurant) {
        return Order::where('restaurant_id', $restaurant)
            ->whereDate('orders.created_at', DB::raw('CURDATE()'))
            ->where('orders.order_status_id', 1)->get();

        // return Restaurant::with(['restaurant_orders' => function ($query) {
        //     $query->whereDate('orders.created_at', DB::raw('CURDATE()'))
        //         ->where('orders.order_status_id', 1)->get();
        // }])->find($id);

    }
    public function todayOrdersInDeliveryByRestaurantId($restaurant) {
        return Order::where('restaurant_id', $restaurant)
            ->whereDate('orders.created_at', DB::raw('CURDATE()'))
            ->where('orders.order_status_id', 2)->get();
        // return Restaurant::with(['restaurant_orders' => function ($query) {
        //     $query->whereDate('orders.created_at', DB::raw('CURDATE()'))
        //         ->where('orders.order_status_id', 2)->get();
        // }])->find($id);
    }
    public function ordersInPreparationByRestaurant($restaurant) {
        return Order::where('restaurant_id', $restaurant)
            ->whereDate('orders.created_at', DB::raw('CURDATE()'))
            ->where('orders.order_status_id', 1)->get();
    }
    public function ordersInDeliveryByRestaurant($restaurant) {
        return Order::where('restaurant_id', $restaurant)
            ->whereDate('orders.created_at', DB::raw('CURDATE()'))
            ->where('orders.order_status_id', 2)->get();
    }
    public function CompletedOrdersByRestaurant($restaurant) {
        return Order::where('restaurant_id', $restaurant)
            ->whereDate('orders.created_at', DB::raw('CURDATE()'))
            ->where('orders.order_status_id', 3)->get();
    }
    public function cancelledOrdersByRestaurant($restaurant) {
        return Order::where('restaurant_id', $restaurant)
            ->whereDate('orders.created_at', DB::raw('CURDATE()'))
            ->where('orders.order_status_id', 4)->get();
    }

    public function ordersByDate($date, $restaurant) {
        return Order::where('restaurant_id', $restaurant)
            ->whereDate('created_at', $date)->get();
    }
    public function getOrdersByDate($start_date, $end_date, $restaurant) {
        return Order::with('items', 'items.category')->whereDate('orders.created_at', '>=', $start_date)
            ->whereDate('orders.created_at', '<=', $end_date)
            ->where('restaurant_id', $restaurant)
            ->get();

    }

}
