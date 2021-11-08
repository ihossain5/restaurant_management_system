<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Combo;
use App\Models\Item;
use App\Models\Restaurant;
use App\Models\RestaurantDeliveryLocation;
use App\Services\CartService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller {
    // public $cartService;
    // public $deliveryFee;
    // public function __construct() {
    //     $this->cartService = new CartService();
    // }

    public function addToCart(Request $request) {
        // dd($request->all());
        $deliveryFee = $this->getDeliveryFee($request->restaurant_id, $request->locationId);
        $cartService = $this->cartObject($deliveryFee);

        $restaurant = Restaurant::with('status')->findOrFail($request->restaurant_id);
        if ($restaurant->status->name == 'BUSY') {
            $data['message']       = 'This Restaurant is a little busy right now. So, your order can take a bit more time than usual. Do you still want to order?';
            $data['status']        = 'BUSY';
            $data['item_id']       = $request->item_id;
            $data['restaurant_id'] = $request->restaurant_id;
            $data['combo_id']      = $request->combo_id;
            return response()->json([
                'success' => false,
                'data'    => $data,
            ]);
        } else if ($restaurant->status->name == 'CLOSED') {
            $data['message'] = 'This Restaurant is closed now.';
            return response()->json([
                'success' => false,
                'data'    => $data,
            ]);
        } else {
            if (Session::has('sessionRestaurantId')) {
                $sessionId = Session::get('sessionRestaurantId');
                if ($sessionId != $request->restaurant_id) {
                    $data['item_id']       = $request->item_id;
                    $data['restaurant_id'] = $request->restaurant_id;
                    $data['combo_id']      = $request->combo_id;
                    $data['location_id']   = $request->locationId;
                    $data['message']       = 'You have already selected items from a different restaurant. If you continue, your cart & selection will be removed';

                    return response()->json([
                        'success' => false,
                        'data'    => $data,
                    ]);
                } else {
                    if ($request->has('combo_id')) {
                        $cart = $cartService->addComboToCart($this->findComboById($request->combo_id));
                    } else {
                        $cart = $cartService->addToCart($this->findItemById($request->item_id));
                    }
                }
            } else {
                if ($request->has('combo_id')) {
                    $cart = $cartService->addComboToCart($this->findComboById($request->combo_id));
                } else {
                    $cart = $cartService->addToCart($this->findItemById($request->item_id));
                }
                if ($cart == true) {
                    Session::put('sessionRestaurantId', $request->restaurant_id);
                }
            }
            $data                      = [];
            $data['message']           = 'Item has been added into cart';
            $data['items']             = $cartService->allCartItems();
            $data['subTotal']          = $cartService->grandTotal();
            $data['numberOfCartItems'] = $cartService->numberOfCartItems();
            $data['grandTotal']        = $cartService->getTotalAmount();
            $data['vatAmount']         = $cartService->getVatAmount();
            $data['deliveryCharge']    = $cartService->deliveryCharge;
            return success($data);
        }

    }

    public function addToCartBusyRestaurant(Request $request) {
        // dd($request->all());
        if (Session::has('sessionRestaurantId')) {
            $sessionId = Session::get('sessionRestaurantId');
            if ($sessionId != $request->restaurant_id) {
                $data['item_id']       = $request->item_id;
                $data['restaurant_id'] = $request->restaurant_id;
                $data['combo_id']      = $request->combo_id;
                $data['message']       = 'You have already selected items from a different restaurant. If you continue, your cart & selection will be removed';

                return response()->json([
                    'success' => false,
                    'data'    => $data,
                ]);
            }
        }
        if ($request->combo_id != null) {
           
            $cart = $this->addComboCart($request->combo_id);
        } else {
            $cart = $this->addItemCart($request->item_id);
        }
        Session::put('sessionRestaurantId', $request->restaurant_id);
        $data                      = [];
        $data['message']           = 'Item has been added into cart';
        $data['items']             = $this->cartService->allCartItems();
        $data['subTotal']          = $this->cartService->grandTotal();
        $data['numberOfCartItems'] = $this->cartService->numberOfCartItems();
        $data['grandTotal']        = totalAmount($this->cartService->grandTotal(), 60);
        return success($data);
    }

    public function changeRestautantToCart(Request $request) {
        // dd($request->all());
        $deliveryFee = $this->getDeliveryFee($request->restaurant_id, $request->locationId);
        $cartService = $this->cartObject($deliveryFee);

        Cart::destroy();
        Session::forget('sessionRestaurantId'); // forget old restaurant id

        if ($request->combo_id != null) {
            $cartService->addComboToCart($this->findComboById($request->combo_id));
        } else {
             $cartService->addToCart($this->findItemById($request->item_id));
        }
        Session::put('sessionRestaurantId', $request->restaurant_id); // put new restaurant id

        $data                      = [];
        $data['message']           = 'Item has been added into cart';
        $data['items']             = $cartService->allCartItems();
        $data['subTotal']          = $cartService->grandTotal();
        $data['numberOfCartItems'] = $cartService->numberOfCartItems();
        $data['grandTotal']        = $cartService->getTotalAmount();
        $data['vatAmount']         = $cartService->getVatAmount();
        $data['deliveryCharge']    = $cartService->deliveryCharge;
        return success($data);
    }

    public function increaseCartQuantity(Request $request) {
        // dd($request->all());
        $cartService = $this->cartObject($request->delivery_fee);
        $cartService->increaseCartQty($request->rowId);
        return success($this->cartTotal($cartService,$request->rowId));
    }

    public function decreaseCartQuantity(Request $request) {
        $cartService = $this->cartObject($request->delivery_fee);
        $cartService->decreaseCartQty($request->rowId);
        return success($this->cartTotal($cartService,$request->rowId));
    }

    public function deleteCart(Request $request) {
        $cartService = $this->cartObject($request->delivery_fee);
        Cart::remove($request->rowId);
        $cartItems = $cartService->numberOfCartItems();
        if ($cartItems == 0) {
            Session::forget('delivery_charge');
            Session::forget('vatAmount');
            Session::forget('sessionRestaurantId');
            $data['deliveryCharge'] = 0;
        } else {
            $data['deliveryCharge'] = $cartService->deliveryCharge;
        }
        $data['grandTotal']        = $cartService->grandTotal();
        $data['numberOfCartItems'] = $cartItems;
        $data['totalAmount']       = currency_format($cartService->getTotalAmount());
        $data['vatAmount']         = currency_format($cartService->getVatAmount());
        return success($data);
    }

    protected function cartTotal($cartService,$rowId) {
        $data                      = [];
        $data['grandTotal']        = $cartService->grandTotal();
        $data['numberOfCartItems'] = $cartService->numberOfCartItems();
        $data['price']             = currency_format($cartService->subtotal($rowId));
        $data['totalAmount']       = currency_format($cartService->getTotalAmount());
        $data['vatAmount']         = currency_format($cartService->getVatAmount());
        $data['deliveryCharge']    = $cartService->deliveryCharge;
        return $data;
    }

    protected function findComboById($id) {
        return Combo::findOrFail($id);
    }

    protected function findItemById($id) {
        return Item::findOrFail($id);
    }

    // protected function addComboCart($id) {
    //     $combo = Combo::findOrFail($id);
    //     return $this->cartService->addComboToCart($combo);
    // }

    // protected function addItemCart($id) {
    //     $item = Item::findOrFail($id);
    //     return $this->cartService->addToCart($item);
    // }

    // get delivery fee by restaurant location
    protected function getDeliveryFee($restaurant_id, $location_id) {
        $restaurant_delivery_locations = RestaurantDeliveryLocation::select('delivery_fee')->where('restaurant_id', $restaurant_id)
            ->where('delivery_location_id', $location_id)
            ->first();
        if (Session::has('delivery_charge')) {
            Session::forget('delivery_charge');
        }

        Session::put('delivery_charge', $restaurant_delivery_locations->delivery_fee);
        return $restaurant_delivery_locations->delivery_fee;
    }

    // get object of cart service
    protected function cartObject($deliveryFee) {
        return new CartService(10, $deliveryFee);
    }

}
