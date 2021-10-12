<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManagerDashboardController extends Controller {
    public $order;
    public function __construct(Order $order) {
        $this->order = $order;
    }
    public function index() {
        $restaurant      = Auth::user()->restaurant;
        $orders          = $this->order->todayOrdersInPreparationByRestaurantId($restaurant->restaurant_id);
        $delivery_orders = $this->order->todayOrdersInDeliveryByRestaurantId($restaurant->restaurant_id);
        $new_orders      = $this->order->todayOrdersByRestaurantId($restaurant->restaurant_id);

        $ordersInPreparation = count($orders);
        $ordersInDelivery    = count($delivery_orders);
        $total_new_orders    = count($new_orders);

        return view('manager.manager_dashboard', compact('ordersInPreparation', 'ordersInDelivery', 'total_new_orders'));
    }
    public function updateRestaurantStatus(Request $request) {
        $restaurant = Auth::user()->restaurant;
        $restaurant->update([
            'restaurant_status_id' => $request->id,
        ]);
        return success($restaurant->status->name);
    }
    public static function restaurant_status() {
        return Auth::user()->restaurant->status->name;
    }
    public static function countedOrders() {
        $restaurant = Auth::user()->restaurant;
        $new_order  = Order::where('restaurant_id', $restaurant->restaurant_id)
            ->whereDate('orders.created_at', DB::raw('CURDATE()'))->count();

        $ordersInPreparation = Order::where('restaurant_id', $restaurant->restaurant_id)
            ->whereDate('orders.created_at', DB::raw('CURDATE()'))
            ->where('orders.order_status_id', 1)->count();
        $ordersInDelivery = Order::where('restaurant_id', $restaurant->restaurant_id)
            ->whereDate('orders.created_at', DB::raw('CURDATE()'))
            ->where('orders.order_status_id', 2)->count();
        $completedOrder = Order::where('restaurant_id', $restaurant->restaurant_id)
            ->whereDate('orders.created_at', DB::raw('CURDATE()'))
            ->where('orders.order_status_id', 3)->count();
        $cancelledOrder = Order::where('restaurant_id', $restaurant->restaurant_id)
            ->whereDate('orders.created_at', DB::raw('CURDATE()'))
            ->where('orders.order_status_id', 4)->count();

        $data = [
            'new_order'           => $new_order,
            'ordersInPreparation' => $ordersInPreparation,
            'ordersInDelivery'    => $ordersInDelivery,
            'completedOrder'      => $completedOrder,
            'cancelledOrder'      => $cancelledOrder,
        ];
        return $data;
    }
}
