<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Combo;
use App\Models\Item;
use App\Models\Restaurant;
use App\Services\CartService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller {
    public $cartService;
    public function __construct(CartService $cartService) {
        $this->cartService = $cartService;
    }

    public function addToCart(Request $request) {
        // dd($request->all());
        $restaurant = Restaurant::findOrFail($request->restaurant_id);
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
                } else {
                    if ($request->has('combo_id')) {
                        $cart = $this->addComboCart($request->combo_id);
                    } else {
                        $cart = $this->addItemCart($request->item_id);
                    }
                }
            } else {
                if ($request->has('combo_id')) {
                    $cart = $this->addComboCart($request->combo_id);
                } else {
                    $cart = $this->addItemCart($request->item_id);
                }
                if ($cart == true) {
                    Session::put('sessionRestaurantId', $request->restaurant_id);
                }
            }
            $data                      = [];
            $data['message']           = 'Item has been added into cart';
            $data['items']             = $this->cartService->allCartItems();
            $data['subTotal']          = $this->cartService->grandTotal();
            $data['numberOfCartItems'] = $this->cartService->numberOfCartItems();
            $data['grandTotal']        = $this->cartService->getTotalAmount();
            $data['vatAmount']         = $this->cartService->getVatAmount();
            $data['deliveryCharge']    = $this->cartService->deliveryCharge;
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
        Cart::destroy();
        Session::forget('sessionRestaurantId');

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
        $data['grandTotal']        = $this->cartService->getTotalAmount();
        $data['vatAmount']         = $this->cartService->getVatAmount();
        $data['deliveryCharge']    = $this->cartService->deliveryCharge;
        return success($data);
    }

    public function increaseCartQuantity(Request $request) {
        $this->cartService->increaseCartQty($request->rowId);
        return success($this->cartTotal($request->rowId));
    }

    public function decreaseCartQuantity(Request $request) {
        $this->cartService->decreaseCartQty($request->rowId);
        return success($this->cartTotal($request->rowId));
    }

    public function deleteCart(Request $request) {
        Cart::remove($request->rowId);
        $cartItems = $this->cartService->numberOfCartItems();
        if ($cartItems == 0) {
            Session::forget('deliveryCharge');
            Session::forget('vatAmount');
            Session::forget('sessionRestaurantId');
            $data['deliveryCharge'] = 0;
        } else {
            $data['deliveryCharge'] = $this->cartService->deliveryCharge;
        }
        $data['grandTotal']        = $this->cartService->grandTotal();
        $data['numberOfCartItems'] = $cartItems;
        $data['totalAmount']       = currency_format($this->cartService->getTotalAmount());
        $data['vatAmount']         = currency_format($this->cartService->getVatAmount());
        return success($data);
    }

    protected function cartTotal($rowId) {
        $data                      = [];
        $data['grandTotal']        = $this->cartService->grandTotal();
        $data['numberOfCartItems'] = $this->cartService->numberOfCartItems();
        $data['price']             = currency_format($this->cartService->subtotal($rowId));
        $data['totalAmount']       = currency_format($this->cartService->getTotalAmount());
        $data['vatAmount']         = currency_format($this->cartService->getVatAmount());
        $data['deliveryCharge']    = $this->cartService->deliveryCharge;
        return $data;
    }

    protected function addComboCart($id) {
        $combo = Combo::findOrFail($id);
        return $this->cartService->addComboToCart($combo);
    }
    protected function addItemCart($id) {
        $item = Item::findOrFail($id);
        return $this->cartService->addToCart($item);
    }



}
