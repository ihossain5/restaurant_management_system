<?php

namespace App\View\Composers;

use App\Models\Restaurant;
use App\Services\CartService;
use Illuminate\View\View;

class CartComposer extends CartService {

    public function __construct() {
        parent::__construct(10, session()->get('delivery_charge'));
    }

    public function compose(View $view) {
        $view->with([
            'totalAmount'     => $this->getTotalAmount(),
            'vatAMount'       => $this->getVatAmount(),
            'deliveryCharge'  => $this->deliveryCharge,
            'subTotal'        => $this->grandTotal(),
            'restaurant_name' => $this->getRestaurantName(),
        ]);
    }

    protected function getRestaurantName() {
        if(session()->has('sessionRestaurantId')){
            $restaurant = Restaurant::findOrFail(session()->get('sessionRestaurantId'));
            return $restaurant->name;
        }
    }
}