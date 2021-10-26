<?php

namespace App\Http\Controllers\Frontend;

use App\Events\MyEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Models\Combo;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Restaurant;
use App\Services\CartService;
use Carbon\Carbon;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckOutController extends Controller {
    public function index(CartService $cart) {
        // dd(Auth::user()->name);
        if (Auth::guard('customer')->check()) {
            if($cart->numberOfCartItems()>0){
                $restaurant_id = Session::get('sessionRestaurantId');
                $restaurant    = Restaurant::findOrFail($restaurant_id);
                $customer      = Auth::guard('customer')->user();
                return view('frontend.checkout.checkout', compact('restaurant', 'customer'));
            }else{
                abort('404');
            }
        
        } else {
            Session::flash('warning', 'Please sign in to continue');
            return view('frontend.customer.sign_in');
        }

    }

    public function placeOrder(OrderStoreRequest $request) {
        dd($request->all());
        $customer_id = Auth::guard('customer')->user()->customer_id;
        $customer    = Customer::findOrFail($customer_id);
        $items       = Cart::content();
        $subtotal    = Cart::subtotal();
        $restaurant  = Restaurant::findOrFail($request->restaurant_id);
       
        $max = Order::where('restaurant_id',$request->restaurant_id)->max('id');
        if($max == null){
            $id = str_pad(1, 4, '0', STR_PAD_LEFT);
        }else{
            $id = str_pad(++$max, 4, '0', STR_PAD_LEFT);
        }
        // dd('sdsds');
        $order = new Order();
        try {
            DB::transaction(function () use ($request, $customer, $order, $items, $subtotal,$id) {
                if ($request->has('setDefaultAddress')) {
                    $customer->update([
                        'contact' => $request->contact,
                        'address' => $request->address,
                    ]);
                    $order->is_default_contact = 1;
                    $order->is_default_address = 1;
                    // dd('sss');
                } else {
                    $order->address = $request->address;
                    $order->contact = $request->contact;
                }

                if ($request->has('setDefaultInfo')) {
                    $customer->update([
                        'name'  => $request->name,
                        'email' => $request->email,
                    ]);
                    $order->is_default_name = 1;
                    // $order->is_default_address = 1;
                } else {
                    $order->name = $request->name;
                    // $order->email = $request->email;
                }

                $order->restaurant_id = $request->restaurant_id;
                $order->customer_id   = $customer->customer_id;
                $order->delivery_fee  = 60;
                $order->id  = $id;
                $order->special_notes = $request->instruction;
                $order->amount        = formatAmount($subtotal);
                $order->save();

                // insert into pivot table
                foreach ($items as $item) {
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

                //destroy cart
                Cart::destroy();
                Session::forget('sessionRestaurantId');
                Session::flash('success', 'Thanks for your order'); 
             
                    $newOrder = Order::where('order_status_id', null)
                    ->where('restaurant_id', $request->restaurant_id)
                    ->whereDate('created_at', Carbon::today())
                    ->count();

                    event(new MyEvent($newOrder, $request->restaurant_id));
    
                  
                
               
            });
            return success($order);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
