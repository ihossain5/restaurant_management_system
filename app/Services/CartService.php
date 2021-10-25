<?php

namespace App\Services;

use Gloudemans\Shoppingcart\Facades\Cart;

Class CartService {
    public function addToCart($item) {
        Cart::add($item->item_id, $item->name, 1, $item->price)
        ->associate('App\Models\Item');
        return true;
    }
    public function addComboToCart($combo) {
        Cart::add([
            'id'      => $combo->combo_id,
            'name'    => $combo->name,
            'qty'     => 1,
            'price'   => $combo->price,
            'options' => ['combo_id' => $combo->combo_id ?? ''],
        ])->associate('App\Models\Combo');
        return true;
    }

    public function increaseCartQty($rowId) {
        $cart = $this->getCart($rowId);
        $qty  = $cart->qty + 1;
        return $this->updateCart($rowId, $qty);

    }

    public function decreaseCartQty($rowId) {
        $cart = $this->getCart($rowId);
        $qty  = $cart->qty - 1;
        return $this->updateCart($rowId, $qty);
    }

    public function getCart($rowId) {
        return Cart::get($rowId);
    }

    public function subtotal($rowId) {
        return Cart::get($rowId)->subtotal;
    }
    public function grandTotal() {
        return Cart::subtotal();
    }

    public function updateCart($rowId, $qty) {
        return Cart::update($rowId, $qty);
    }
}