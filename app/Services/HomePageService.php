<?php

namespace App\Services;

use App\Models\Combo;
use App\Models\DeliveryLocation;
use App\Models\HomeHeroSection;
use App\Models\Item;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

Class HomePageService {

    public function popularDishes() {
        $items = Item::where('is_available', 1)->withCount([
            'category',
            'orders',
            'orders as counted_order' => function ($query) {
                $query->whereMonth('orders.created_at', '=', Carbon::now()->subMonth()->month)
                    ->where('order_status_id', 3);
            }])->orderBy('counted_order', 'DESC')->get();

        if (session()->has('restaurantIds')) {
            $this->formatPopularDishes($items);
        }
        return $items;
    }

    public function combos() {
        $combos = Combo::with('items')->where('is_available', 1)->get();
        if (session()->has('restaurantIds')) {
            $this->formatCombos($combos);
        }
        return $combos;
    }

    public function getDeliveryLocations() {
        return DeliveryLocation::get()->unique('name');
    }

    public function heroSlider() {
        return HomeHeroSection::all();
    }

    public function restaurants() {
        $restaurants = Restaurant::with('assets')->where('is_open', 1)->latest()->get();
        $this->formatRestaurant($restaurants);
        return $restaurants;
    }

    public function getRestaurantByLocation($id) {
        $location    = DeliveryLocation::with('restaurants')->findOrFail($id);
        $restaurants = $location->restaurants;
        $this->setLocationId($location->delivery_location_id);
        $this->setLocationName($location->name);
        $this->setRestaurantId($restaurants->pluck('restaurant_id'));
        return $location;

    }

    private function setLocationId($location_id) {
        if (Session::has('location_id')) {
            Session::forget('location_id');
        }
        Session::put('location_id', $location_id);
    }
    private function setLocationName($name) {
        if (Session::has('location_name')) {
            Session::forget('location_name');
        }
        Session::put('location_name', $name);
    }
    private function setRestaurantId($restaurantId) {
        if (Session::has('restaurantIds')) {
            Session::forget('restaurantIds');
        }
        Session::put('restaurantIds', $restaurantId);
    }

    private function formatRestaurant($restaurants) {
        foreach ($restaurants as $restaurant) {
            if (session()->has('restaurantIds')) {
                if (in_array($restaurant->restaurant_id, $this->getRestaurantFromSession())) {
                    $restaurant->disable = false;
                } else {
                    $restaurant->disable = true;
                }
            }

            foreach ($restaurant->assets as $asset) {
                if ($asset->pivot->section == 'home') {
                    $restaurant->asset = $asset->pivot->asset;
                    break;
                }
            }
        }
    }

    private function formatPopularDishes($items) {
        foreach ($items as $item) {
            if (in_array($item->category->restaurant->restaurant_id, $this->getRestaurantFromSession())) {
                $item->disable = false;
            } else {
                $item->disable = true;
            }
        }
    }

    private function formatCombos($combos) {
        foreach ($combos as $combo) {
            foreach ($combo->items as $item) {
                $combo->restaurant    = $item->category->restaurant->name;
                $combo->restaurant_id = $item->category->restaurant->restaurant_id;

                if (in_array($item->category->restaurant->restaurant_id, $this->getRestaurantFromSession())) {
                    $combo->disable = false;
                } else {
                    $combo->disable = true;
                }
            }
        }
    }

    private function getRestaurantFromSession() {
        if (session()->has('restaurantIds')) {
            return Session::get('restaurantIds')->toArray();
        }
    }
}