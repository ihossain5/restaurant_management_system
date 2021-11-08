<?php

namespace App\Services;

use App\Models\Combo;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

Class CheckoutService extends CartService {

    public function __construct() {
        parent::__construct(10, session()->get('delivery_charge'));
    }

    public function storeOrder($setDefaultAddress, $contact, $address, $setDefaultContact, $name, $restaurant_id, $instruction) {
        $order = new Order();
        if ($setDefaultAddress != null) {
            $this->updateCustomerContact($contact, $address);
        } else {
            $order->address            = $address;
            $order->contact            = $contact;
            $order->is_default_contact = 1;
            $order->is_default_address = 1;
        }
        if ($setDefaultContact != null) {
            $this->updateCustomerContact($contact, $address);
        } else {
            $order->is_default_name = 1;
            $order->name            = $name;
        }

        $order->restaurant_id = $restaurant_id;
        $order->customer_id   = Auth::guard('customer')->user()->customer_id;
        $order->delivery_fee  = $this->deliveryCharge;
        $order->vat_amount    = $this->getVatAmount();
        $order->id            = $this->getMaxId($restaurant_id);
        $order->special_notes = $instruction;
        $order->amount        = $this->getTotalAmount();
        $order->save();
        $order->load('items','order_combos');
        $this->storeItems($order);
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
        $customer_id = Auth::guard('customer')->user()->customer_id;
        $customer    = Customer::findOrFail($customer_id);
        $customer->update([
            'contact' => $contact,
            'address' => $address,
        ]);
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