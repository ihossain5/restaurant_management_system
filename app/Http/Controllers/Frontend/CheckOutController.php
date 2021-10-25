<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Combo;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Restaurant;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckOutController extends Controller {
    public function index() {
        if (Auth::guard('customer')->check()) {
            $restaurant_id = Session::get('sessionRestaurantId');
            $restaurant    = Restaurant::findOrFail($restaurant_id);
            $customer      = Auth::guard('customer')->user();
            return view('frontend.checkout.checkout', compact('restaurant', 'customer'));
        } else {
            Session::flash('warning', 'Please sign in to continue');
            return view('frontend.customer.sign_in');
        }

    }

    public function placeOrder(Request $request) {
        // dd($request->all());
        $customer_id = Auth::guard('customer')->user()->customer_id;
        $customer    = Customer::findOrFail($customer_id);
        // dd($customer_id);
        // if ($request->has('setDefaultAddress')) {
        //     $customer->update([
        //         'address' => $request->address ?? $customer->address,
        //         'contact' => $request->contact ?? $customer->address,
        //         'name'    => $request->name ?? $customer->name,
        //         'email'   => $request->email ?? $customer->email,
        //     ]);
        // } else {
        //     dd('wwwwww');
        // }

        $items                = Cart::content();
        $subtotal             = Cart::subtotal();
        $total                = floatval(preg_replace('/[^\d.]/', '', $subtotal));
        $order                = new Order();
        $order->restaurant_id = $request->restaurant_id;
        $order->customer_id   = $customer_id;
        $order->name          = '1';
        $order->contact       = '1';
        $order->address       = '1';
        $order->delivery_fee  = 60;
        $order->apology_note  = '1';
        $order->special_notes = '1';
        $order->amount        = ($total + 60);
        $order->save();

        foreach ($items as $item) {
            if (Arr::exists($item->options, 'combo_id')) {
                $combo = Combo::findOrFail($item->id);
            } else {
                $order->items()->attach([$item->id => [
                    'quantity' => $item->qty,
                    'price'    => floatval(preg_replace('/[^\d.]/', '', $item->price)),
                ]]);
            }

        }
    }
}
