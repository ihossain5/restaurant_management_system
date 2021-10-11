<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ManagerOrdersController extends Controller {
    public $order;
    public function __construct(Order $order) {
        $this->order = $order;
    }
    public function newOrders(Request $request) {
        $restaurant = Auth::user()->restaurant;
        $new_orders = $this->order->todayOrdersByRestaurantId($restaurant->restaurant_id);
        if ($request->ajax()) {
            return $this->dataTable($new_orders);
        }
        return view('manager.orders.new_orders');
    }
    public function ordersInPreparation(Request $request) {
        $restaurant          = Auth::user()->restaurant;
        $ordersInPreparation = $this->order->allOrdersInDeliveryByRestaurant($restaurant->restaurant_id);
        if ($request->ajax()) {
            return $this->dataTable($ordersInPreparation);
        }
        return view('manager.orders.orders_in_preparation');

    }
    public function ordersInDelivery(Request $request) {
        $restaurant          = Auth::user()->restaurant;
        $ordersInDelivery = $this->order->allOrdersInPreparationByRestaurant($restaurant->restaurant_id);
        if ($request->ajax()) {
            return $this->dataTable($ordersInDelivery);
        }
        return view('manager.orders.orders_in_delivery');
    }
    public function completedOrders(Request $request) {
        $restaurant          = Auth::user()->restaurant;
        $ordersInDelivery = $this->order->allCompletedOrdersRestaurant($restaurant->restaurant_id);
        if ($request->ajax()) {
            return $this->dataTable($ordersInDelivery);
        }
        return view('manager.orders.completed_orders');
    }

    public function dataTable($ordersData) {
        return DataTables::of($ordersData)
            ->addIndexColumn()
            ->addColumn('customer_name', function ($data) {
                $customer_name = $data->is_default_name == 0 ? $data->name : $data->customer->name;
                return $customer_name;
            })
            ->addColumn('customer_contact', function ($data) {
                $customer_contact = $data->is_default_contact == 0 ? $data->contact : $data->customer->contact;
                return $customer_contact;
            })
            ->addColumn('customer_adress', function ($data) {
                $customer_adress = $data->is_default_address == 0 ? $data->address : $data->customer->address;
                return $customer_adress;
            })
            ->addColumn('action', function ($data) {
                $actionBtn = "<button type='button' class='btn btn-outline-dark' onclick='viewOrder($data->order_id)'>
            <i class='fa fa-eye'></i>
        </button>";
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
