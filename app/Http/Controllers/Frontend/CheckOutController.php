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
use App\Services\CheckoutService;
use App\Services\OrderService;
use Carbon\Carbon;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckOutController extends Controller {
    // public $cart;
    // public function __construct(CartService $cart) {
    //     $this->cart = $cart;
    // }

    public function index() {
        // dd(Auth::user()->name);
        if (Auth::guard('customer')->check()) {
            $cart = new CartService(10, session()->get('delivery_charge'));
            if ($cart->numberOfCartItems() > 0) {
                $restaurant_id = Session::get('sessionRestaurantId');
                $restaurant    = Restaurant::findOrFail($restaurant_id);
                $customer      = Auth::guard('customer')->user();
                return view('frontend.checkout.checkout', compact('restaurant', 'customer'));
            } else {
                abort('404');
            }

        } else {
            Session::flash('warning', 'Please sign in to continue');
            return view('frontend.customer.sign_in');
        }

    }

    public function placeOrder(OrderStoreRequest $request, CheckoutService $checkoutService) {
        // dd($request->all());
        $checkoutService->storeOrder($request->setDefaultAddress,$request->contact,$request->address,$request->setDefaultContact,$request->name,$request->restaurant_id,$request->instruction);
        // $customer_id = Auth::guard('customer')->user()->customer_id;
        // $customer    = Customer::findOrFail($customer_id);
        // $items       = $checkoutService->allCartItems();
        // $subtotal    = $checkoutService->getTotalAmount();

        // $restaurant = Restaurant::with('status')->findOrFail($request->restaurant_id);
        // if ($restaurant->status->name == 'CLOSED') {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'This restaurant is closed now. Please select another restaurant',
        //     ]);
        // }

        // // dd('sdsds');
        // $order = new Order();
        // try {
        //     DB::transaction(function () use ($request, $customer, $order, $items, $subtotal,$checkoutService) {
        //         if ($request->has('setDefaultAddress')) {
        //             $customer->update([
        //                 'contact' => $request->contact,
        //                 'address' => $request->address,
        //             ]);

        //             // dd('sss');
        //         } else {
        //             $order->address            = $request->address;
        //             $order->contact            = $request->contact;
        //             $order->is_default_contact = 1;
        //             $order->is_default_address = 1;
        //         }

        //         if ($request->has('setDefaultInfo')) {
        //             $customer->update([
        //                 'name'  => $request->name,
        //                 'email' => $request->email,
        //             ]);

        //             // $order->is_default_address = 1;
        //         } else {
        //             $order->is_default_name = 1;
        //             $order->name            = $request->name;
        //             // $order->email = $request->email;
        //         }

        //         $order->restaurant_id = $request->restaurant_id;
        //         $order->customer_id   = $customer->customer_id;
        //         $order->delivery_fee  = $checkoutService->deliveryCharge;
        //         $order->vat_amount    = $checkoutService->getVatAmount();
        //         $order->id            = $checkoutService->getMaxId($request->restaurant_id);
        //         $order->special_notes = $request->instruction;
        //         $order->amount        = $subtotal;
        //         $order->save();

        //         // insert into pivot table
        //         foreach ($items as $item) {
        //             if (Arr::exists($item->options, 'combo_id')) {
        //                 $combo = Combo::findOrFail($item->id);
        //                 $order->order_combos()->attach([$item->id => [
        //                     'quantity' => $item->qty,
        //                     'price'    => formatAmount($item->subtotal),
        //                 ]]);
        //             } else {
        //                 $order->items()->attach([$item->id => [
        //                     'quantity' => $item->qty,
        //                     'price'    => formatAmount($item->subtotal),
        //                 ]]);
        //             }

        //         }

        //         //destroy cart
        //         Cart::destroy();
        //         Session::forget('sessionRestaurantId');
        //         Session::flash('success', 'Thanks for your order');

        //         $newOrder = Order::where('order_status_id', null)
        //             ->where('restaurant_id', $request->restaurant_id)
        //             ->whereDate('created_at', Carbon::now())
        //             ->count();

        //         event(new MyEvent($newOrder, $request->restaurant_id));

        //     });
        //     return success($order);

        // } catch (Exception $e) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => $e->getMessage(),
        //     ]);
        // }
    }

    public function orderPlaced(Order $order, OrderService $orderService) {
        $order->load('restaurant', 'items', 'order_combos', 'customer');
        $orderItems = $orderService->orderItems($order);
        $contact    = $order->is_default_contact == 1 ? $order->contact : $order->customer->contact;
        return view('frontend.orders.order_placed', compact('order', 'orderItems', 'contact'));
    }

}
