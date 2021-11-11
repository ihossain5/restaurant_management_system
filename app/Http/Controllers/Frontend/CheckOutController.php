<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\RestaurantDeliveryLocation;
use App\Services\CheckoutService;
use App\Services\OrderService;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckOutController extends Controller {
    // public $checkoutService;
    // public function __construct(CheckoutService $checkoutService) {
    //     $this->checkoutService = $checkoutService;
    // }

    public function index() {
        if (Auth::guard('customer')->check()) {
            if (count(Cart::content()) > 0) {
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

    public function placeOrder(OrderStoreRequest $request) {
        // dd($request->all());
        $restaurant = Restaurant::with('status')->findOrFail($request->restaurant_id);
        if ($restaurant->status->name == 'CLOSED') {
            return response()->json([
                'success' => false,
                'message' => 'This restaurant is closed now. Please select another restaurant',
            ]);
        }
        $deliveryLocation = RestaurantDeliveryLocation::where('delivery_location_id', session()->get('location_id'))
            ->where('restaurant_id', $request->restaurant_id)
            ->first();
        if (!$deliveryLocation) {
            return response()->json([
                'success' => false,
                'message' => 'Delivery is not available in your selected area.',
            ]);
        }
        try {
            $deliveryCharge  = formatAmount($request->deliveryCharge);
            $checkoutService = new CheckoutService($deliveryCharge);
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
