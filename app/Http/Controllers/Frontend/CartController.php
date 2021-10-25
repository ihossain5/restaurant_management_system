<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Combo;
use App\Models\Item;
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
        if (Session::has('sessionRestaurantId')) {
            $sessionId = Session::get('sessionRestaurantId');
            if ($sessionId != $request->restaurant_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You can not add items from multiple restaurant',
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

        $data               = [];
        $data['message']    = 'Item has been added into cart';
        $data['items']      = Cart::content();
        $data['grandTotal'] = $this->cartService->grandTotal();
        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
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
        $data['grandTotal'] = $this->cartService->grandTotal();
        return success($data);
    }

    public function cartTotal($rowId) {
        $data               = [];
        $data['grandTotal'] = $this->cartService->grandTotal();
        $data['price']      = $this->cartService->subtotal($rowId);
        return $data;
    }

    public function addComboCart($id) {
        $combo = Combo::findOrFail($id);
        return $this->cartService->addComboToCart($combo);
    }
    public function addItemCart($id) {
        $item = Item::findOrFail($id);
        return $this->cartService->addToCart($item);
    }
}
