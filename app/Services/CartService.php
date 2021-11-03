<?php

namespace App\Services;

use Gloudemans\Shoppingcart\Facades\Cart;

Class CartService {
    public $vat;
    public $deliveryCharge;

    public function __construct($vat = 10, $deliveryCharge = 60) {
        $this->vat            = $vat;
        $this->deliveryCharge = $this->getRoundAmount($deliveryCharge);
    }

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
            'options' => [
                'combo_id' => $combo->combo_id ?? '',
            ],
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

    public function numberOfCartItems() {
        return count($this->allCartItems());
    }

    public function allCartItems() {
        return Cart::content();
    }

    public function updateCart($rowId, $qty) {
        return Cart::update($rowId, $qty);
    }

    public function getVatAmount() {
        $amount =  (formatAmount($this->grandTotal()) * $this->vat) / 100;
        return $this->getRoundAmount($amount);
    }

    public function getTotalAmount() {
        $total = formatAmount($this->grandTotal()) + $this->getVatAmount() + $this->getDeliveryCharge();
        return $this->getRoundAmount($total);
    }

    protected function getRoundAmount($amount) {
        return number_format((float) $amount, 2, '.', '');
    }

    protected function getDeliveryCharge() {
        if ($this->numberOfCartItems() == 0) {
            $deliveryCharge = 0;
        } else {
            $deliveryCharge = $this->deliveryCharge;
        }
        return $deliveryCharge;
    }
}