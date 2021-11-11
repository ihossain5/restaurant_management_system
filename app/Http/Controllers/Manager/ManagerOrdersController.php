<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ManagerOrdersController extends Controller {
    public $order;
    public function __construct(Order $order) {
        $this->order = $order;
    }
    public function newOrders(Request $request) {
        $restaurant = Auth::user()->restaurant;
        $new_orders = $this->order->todayNewOrdersByRestaurantId($restaurant->restaurant_id);
        if ($request->ajax()) {
            return $this->dataTable($new_orders);
        }
        return view('manager.orders.new_orders');
    }
    public function ordersInPreparation(Request $request) {
        $restaurant          = Auth::user()->restaurant;
        $ordersInPreparation = $this->order->ordersInPreparationByRestaurant($restaurant->restaurant_id);
        if ($request->ajax()) {
            return $this->dataTable($ordersInPreparation);
        }
        return view('manager.orders.orders_in_preparation');

    }
    public function ordersInDelivery(Request $request) {
        $restaurant       = Auth::user()->restaurant;
        $ordersInDelivery = $this->order->ordersInDeliveryByRestaurant($restaurant->restaurant_id);
        if ($request->ajax()) {
            return $this->dataTable($ordersInDelivery);
        }
        return view('manager.orders.orders_in_delivery');
    }
    public function completedOrders(Request $request) {
        $restaurant       = Auth::user()->restaurant;
        $completed_orders = $this->order->CompletedOrdersByRestaurant($restaurant->restaurant_id);
        if ($request->ajax()) {
            return $this->orderCompletedDataTable($completed_orders);
        }
        return view('manager.orders.completed_orders');
    }
    public function cancelledOrders(Request $request) {
        $restaurant      = Auth::user()->restaurant;
        $cancelledOrders = $this->order->cancelledOrdersByRestaurant($restaurant->restaurant_id);
        if ($request->ajax()) {
            return $this->orderCancelledDataTable($cancelledOrders);
        }
        return view('manager.orders.cancelled_orders');
    }
    public function cancelOrder(Request $request) {
        $order = Order::findOrFail($request->id);
        $order->update([
            'order_status_id' => 4,
        ]);
        $data['message']              = 'Order has been cancelled';
        $data['order_in_delivery']    = count($this->order->ordersInDeliveryByRestaurant($order->restaurant_id));
        $data['cancel_order']         = count($this->order->cancelledOrdersByRestaurant($order->restaurant_id));
        $data['order_in_preparation'] = count($this->order->ordersInPreparationByRestaurant($order->restaurant_id));
        $data['new_order']            = count($this->order->todayOrdersByRestaurantId($order->restaurant_id));
        $data['completed_order']      = count($this->order->CompletedOrdersByRestaurant($order->restaurant_id));
        return success($data);
    }
    public function acceptOrder(Request $request) {
        $order = Order::findOrFail($request->id);
        $order->update([
            'order_status_id' => 1,
        ]);
        $new_orders                   = $this->order->todayOrdersByRestaurantId($order->restaurant_id);
        $data['id']                   = $order->order_id;
        $data['message']              = 'Order has accepted';
        $data['order_in_preparation'] = count($this->order->ordersInPreparationByRestaurant($order->restaurant_id));
        $data['new_order']            = count($this->order->todayNewOrdersByRestaurantId($order->restaurant_id));
        return success($data);
        // foreach($new_orders as $new_order){
        //     $new_order->order_in_preparation = count($this->order->ordersInPreparationByRestaurant($order->restaurant_id));
        //     $new_order->new_order = count($this->order->todayOrdersByRestaurantId($order->restaurant_id));
        //     $new_order->message = 'Order has accepted';
        // }
        // return $this->dataTable($new_orders);
    }
    public function acceptOrderInPreparation(Request $request) {
        $order = Order::findOrFail($request->id);
        $order->update([
            'order_status_id' => 2,
        ]);
        $data['id']                   = $order->order_id;
        $data['message']              = 'Order has accepted';
        $data['order_in_preparation'] = count($this->order->ordersInPreparationByRestaurant($order->restaurant_id));
        $data['order_in_delivary']    = count($this->order->ordersInDeliveryByRestaurant($order->restaurant_id));
        return success($data);
    }
    public function acceptOrderInDelivery(Request $request) {
        $order = Order::findOrFail($request->id);
        $order->update([
            'order_status_id' => 3,
        ]);
        $data['id']                = $order->order_id;
        $data['message']           = 'Order has accepted';
        $data['completed_order']   = count($this->order->CompletedOrdersByRestaurant($order->restaurant_id));
        $data['order_in_delivary'] = count($this->order->ordersInDeliveryByRestaurant($order->restaurant_id));
        return success($data);
    }

    public function updateOrder(Request $request) {
        // dd($request->all());
        $this->validate($request, [
            // 'item'  => 'required|array',
            // 'item*' => 'required',
        ]);

        $order = Order::with('items', 'order_combos')->findOrFail($request->order_id);
        // dd($order);
        $items      = $request->item;
        $comboItems = $request->comboItem;
        DB::transaction(function () use ($request, $items, $order, $comboItems) {
            $order->update([
                'special_notes' => $request->specialNotes ?? null,
                'amount'        => formatAmount($request->totalAmount),
                'vat_amount'    => formatAmount($request->vatAmount),
            ]);

            if ($items) {
                foreach ($items as $item) {
                    $updated_item[$item['item_id']] = [
                        'quantity' => $item['quantity'],
                        'price'    => formatAmount($item['individualTotal']),
                    ];

                }
                $order->items()->sync($updated_item, true);
            }else{
                $order->items()->detach();
            }

            if ($comboItems) {
                foreach ($comboItems as $comboItem) {
                    $combo_item[$comboItem['item_id']] = [
                        'quantity' => $comboItem['quantity'],
                        'price'    => formatAmount($comboItem['individualTotal']),
                    ];

                }
                $order->order_combos()->sync($combo_item, true);
            }else{
                $order->order_combos()->detach();
            }

        });
        $data['message'] = 'Order has been updated';
        return success($data);
    }

    public function dataTable($ordersData) {
        return DataTables::of($ordersData)
            ->addIndexColumn()
            ->addColumn('customer_name', function ($data) {
                $customer_name = $data->is_default_name == 1 ? $data->name : $data->customer->name;
                return $customer_name;
            })
            ->addColumn('customer_contact', function ($data) {
                $customer_contact = $data->is_default_contact == 1 ? $data->contact : $data->customer->contact;
                return $customer_contact;
            })
            ->addColumn('customer_adress', function ($data) {
                $customer_adress = $data->is_default_address == 1 ? $data->address : $data->customer->address;
                return $customer_adress;
            })
            ->addColumn('action', function ($data) {
                $actionBtn = $data->order_id;
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function orderCompletedDataTable($ordersData) {
        return DataTables::of($ordersData)
            ->addIndexColumn()
            ->addColumn('time', function ($data) {
                $time = Carbon::parse($data->created_at)->format('g:i A');
                return $time;
            })
            ->addColumn('customer_name', function ($data) {
                $customer_name = $data->is_default_name == 1 ? $data->name : $data->customer->name;
                return $customer_name;
            })
            ->addColumn('customer_contact', function ($data) {
                $customer_contact = $data->is_default_contact == 1 ? $data->contact : $data->customer->contact;
                return $customer_contact;
            })
            ->addColumn('customer_adress', function ($data) {
                $customer_adress = $data->is_default_address == 1 ? $data->address : $data->customer->address;
                return $customer_adress;
            })
            ->addColumn('action', function ($data) {
                $actionBtn = $data->order_id;
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function orderCancelledDataTable($ordersData) {
        return DataTables::of($ordersData)
            ->addIndexColumn()
            ->addColumn('time', function ($data) {
                $time = formatDate($data->created_at);
                return $time;
            })
            ->addColumn('customer_name', function ($data) {
                $customer_name = $data->is_default_name == 1 ? $data->name : $data->customer->name;
                return $customer_name;
            })
            ->addColumn('customer_contact', function ($data) {
                $customer_contact = $data->is_default_contact == 1 ? $data->contact : $data->customer->contact;
                return $customer_contact;
            })
            ->addColumn('customer_adress', function ($data) {
                $customer_adress = $data->is_default_address == 1 ? $data->address : $data->customer->address;
                return $customer_adress;
            })
            ->addColumn('action', function ($data) {
                $actionBtn = $data->order_id;
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
