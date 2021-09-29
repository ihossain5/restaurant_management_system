<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboarController extends Controller {
    public function index() {
        $restaurants = Restaurant::with(['restaurant_completed_orders', 'restaurant_orders' => function ($query) {
            $query->whereDate('orders.created_at', DB::raw('CURDATE()'))
                ->get();
        }])->get();
        foreach ($restaurants as $restaurant) {
            $restaurant->revenue          = $restaurant->restaurant_orders->sum('amount');
            $restaurant->completed_orders = $restaurant->restaurant_completed_orders->count();
            $restaurant->cancelled_orders = $restaurant->restaurant_cancelled_orders->count();
        }
        $total_amount = Order::whereDate('created_at', DB::raw('CURDATE()'))->sum('amount');

        $orders = Order::with('restaurant')->whereMonth(
            'created_at', '=', Carbon::now()->subMonth()->month
        )
        ->select(DB::raw("SUM(amount) as total_amont"))
       
        ->groupBy('restaurant_id')
        ->get();
            dd($orders);
        
        // foreach($orders as $order){
        //     // $order->asds = $order->items->sum('pivot.quantity');
        //     $order->items->map(function ($array) {
        //         return collect($array)->unique('item_id')->all();
        //     });
        // }
        // $orderItmes = OrderItem::whereMonth(
        //     'created_at', '=', Carbon::now()->subMonth()->month
        // )->get();
        // foreach($orderItmes as $item){
        //     $item->sds=  $item->sum('quantity');
        // }
        // dd($orderItmes);
        // dd($orderItmes->unique('item_id'));
        


      

        return view('admin.dashboard', compact('restaurants', 'total_amount'));
    }

}
