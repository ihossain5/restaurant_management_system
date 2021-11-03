<?php

namespace App\View\Composers;

use App\Services\CartService;
use Illuminate\View\View;

class CartComposer {

    protected $totalAmount;
    protected $vatAMount;
    protected $deliveryCharge;
    protected $subTotal;

    public function __construct(CartService $cart) {
        $this->totalAmount    = $cart->getTotalAmount();
        $this->vatAMount      = $cart->getVatAmount();
        $this->deliveryCharge = $cart->deliveryCharge;
        $this->subTotal       = $cart->grandTotal();
    }

    public function compose(View $view) {
        $view->with([
            'totalAmount'    => $this->totalAmount,
            'vatAMount'      => $this->vatAMount,
            'deliveryCharge' => $this->deliveryCharge,
            'subTotal'       => $this->subTotal,
        ]);
    }
}