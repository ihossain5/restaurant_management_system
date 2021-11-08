<?php

namespace App\Services;

use App\Events\MyEvent;
use App\Models\Combo;
use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

Class CheckoutService extends CartService {

    public function __construct() {
        parent::__construct(10, session()->get('delivery_charge'));
    }

    // public function storeOrder($setDefaultAddress, $contact, $address, $setDefaultContact, $name, $email, $restaurant_id, $instruction) {
    public function storeOrder($request) {
        $order = new Order();
        DB::transaction(function () use ($request, $order) {
            if ($request->setDefaultAddress != null) {
                $this->updateCustomerContact($request->contact, $request->address);
            } else {
                $order->address            = $request->address;
                $order->contact            = $request->contact;
                $order->is_default_contact = 1;
                $order->is_default_address = 1;
            }
            if ($request->setDefaultContact != null) {
                $this->updateCustomerInfo($request->name, $request->email);
            } else {
                $order->is_default_name = 1;
                $order->name            = $request->name;
            }

            $order->restaurant_id = $request->restaurant_id;
            $order->customer_id   = Auth::guard('customer')->user()->customer_id;
            $order->delivery_fee  = $this->deliveryCharge;
            $order->vat_amount    = $this->getVatAmount();
            $order->id            = $this->getMaxId($request->restaurant_id);
            $order->special_notes = $request->instruction;
            $order->amount        = $this->getTotalAmount();
            $order->save();
            $order->load('items', 'order_combos');
            $this->storeItems($order);
            $this->sendNotificationToManager($request->restaurant_id);
        });
        Cart::destroy();
        Session::forget('sessionRestaurantId');
        return $order;
       
    }

    public function getMaxId($restaurant_id) {
        $max = Order::where('restaurant_id', $restaurant_id)->max('id');
        if ($max == null) {
            $id = str_pad(1, 4, '0', STR_PAD_LEFT);
        } else {
            $id = str_pad(++$max, 4, '0', STR_PAD_LEFT);
        }
        return $id;
    }

    protected function updateCustomerContact($contact, $address) {
        $this->findCustomerById()->update([
            'contact' => $contact,
            'address' => $address,
        ]);
    }

    protected function updateCustomerInfo($name, $email) {
        $this->findCustomerById()->update([
            'name'  => $name,
            'email' => $email,
        ]);
    }

    protected function findCustomerById() {
        return Customer::findOrFail(Auth::guard('customer')->user()->customer_id);
    }

    protected function sendNotificationToManager($restaurant_id){
        event(new MyEvent($this->numberOfNewOrders($restaurant_id), $restaurant_id));
    }

    public function numberOfNewOrders($restaurant_id){
        return Order::where('order_status_id', null)
         ->where('restaurant_id', $restaurant_id)
         ->whereDate('created_at', Carbon::now())
         ->count();
     }

    protected function storeItems($order) {
        // insert into pivot table
        foreach ($this->allCartItems() as $item) {
            if (Arr::exists($item->options, 'combo_id')) {
                $combo = Combo::findOrFail($item->id);
                $order->order_combos()->attach([$item->id => [
                    'quantity' => $item->qty,
                    'price'    => formatAmount($item->subtotal),
                ]]);
            } else {
                $order->items()->attach([$item->id => [
                    'quantity' => $item->qty,
                    'price'    => formatAmount($item->subtotal),
                ]]);
            }

        }
    }
}