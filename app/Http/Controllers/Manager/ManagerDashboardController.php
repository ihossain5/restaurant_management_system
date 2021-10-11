<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\RestaurantStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerDashboardController extends Controller {
    public $order;
    public function __construct(Order $order) {
        $this->order = $order;
    }
    public function index() {
        $restaurant          = Auth::user()->restaurant;
        $orders              = $this->order->todayOrdersInPreparationByRestaurantId($restaurant->restaurant_id);
        $delivery_orders     = $this->order->todayOrdersInDeliveryByRestaurantId($restaurant->restaurant_id);
        $new_orders          = $this->order->todayOrdersByRestaurantId($restaurant->restaurant_id);

        $ordersInPreparation = count($orders);
        $ordersInDelivery    = count($delivery_orders);
        $total_new_orders    = count($new_orders);
        return view('manager.manager_dashboard',compact('ordersInPreparation','ordersInDelivery','total_new_orders'));
    }
    public function updateRestaurantStatus(Request $request){
        $restaurant          = Auth::user()->restaurant;
        $restaurant->update([
            'restaurant_status_id'=> $request->id,
        ]);
        return success($restaurant->status->name);
    }
    public static function restaurant_status(){
        return Auth::user()->restaurant->status->name;
    }
}
