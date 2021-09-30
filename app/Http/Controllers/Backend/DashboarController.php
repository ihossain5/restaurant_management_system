<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Order;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboarController extends Controller {
    public $order;
    public function __construct(Order $order) {
        $this->order = $order;
    }
    public function index() {
        $restaurants = Restaurant::with(['restaurant_completed_orders', 'restaurant_orders' => function ($query) {
            $query->whereDate('orders.created_at', DB::raw('CURDATE()'))
                ->where('order_status_id', 3)
                ->get();
        }])->get();
        foreach ($restaurants as $restaurant) {
            $restaurant->revenue          = $restaurant->restaurant_orders->sum('amount');
            $restaurant->completed_orders = $restaurant->restaurant_completed_orders->count();
            $restaurant->cancelled_orders = $restaurant->restaurant_cancelled_orders->count();
        }
        $total_amount = $this->order->todaysRevenue();
        $orders       = $this->order->lastMonthOrders();
        $order_items = Order::with('items')->whereMonth(
            'created_at', '=', Carbon::now()->subMonth()->month
        )->where('order_status_id', 3)->get();
           
        // dd($order_items);
        // $orderItmes = OrderItem::whereMonth(
        //     'created_at', '=', Carbon::now()->subMonth()->month
        // )->get();
        // foreach($orderItmes as $item){
        //     $item->sds=  $item->sum('quantity');
        // }
        // dd($orderItmes);
        // dd($orderItmes->unique('item_id'));

        return view('admin.dashboard', compact('restaurants', 'total_amount', 'orders','order_items'));
    }

}
