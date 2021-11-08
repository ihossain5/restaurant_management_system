<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Restaurant;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\Services\OrderService;
use Darryldecode\Cart\Cart;
use Exception;
use Illuminate\Support\Facades\Auth;
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
        $restaurant = Restaurant::with('status')->findOrFail($request->restaurant_id);
        if ($restaurant->status->name == 'CLOSED') {
            return response()->json([
                'success' => false,
                'message' => 'This restaurant is closed now. Please select another restaurant',
            ]);
        }
        try {
           return success($checkoutService->storeOrder($request));

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function orderPlaced(Order $order, OrderService $orderService) {
        $order->load('restaurant', 'items', 'order_combos', 'customer');
        $orderItems = $orderService->orderItems($order);
        $contact    = $order->is_default_contact == 1 ? $order->contact : $order->customer->contact;
        return view('frontend.orders.order_placed', compact('order', 'orderItems', 'contact'));
    }

}
