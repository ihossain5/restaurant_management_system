<?php

namespace App\Services;

use App\Models\DeliveryLocation;
use App\Models\Restaurant;
use Illuminate\Support\Facades\File;

class RestaurantService {
    public function all(){
        $restaurants = Restaurant::with('assets')->latest()->get();
        foreach ($restaurants as $restaurant) {
            $description                      = substr($restaurant->description, 0, 25);
            $strip_text  = strip_tags($description);
            $result      = preg_replace('/<(\w+)[^>]*>/', '<$1>', $strip_text);
            $restaurant->formated_description = $result;

            $address                      = substr($restaurant->address, 0, 25);
            $strip_text  = strip_tags($address);
            $address_result      = preg_replace('/<(\w+)[^>]*>/', '<$1>', $strip_text);
            $restaurant->formated_address= $address_result;

            foreach ($restaurant->assets as $asset) {
                $restaurant->asset = $asset->pivot->asset;
            }
            $file_type = File::extension($restaurant->asset);
        }
        return $restaurants;
    }

    public function findById($id){
        return Restaurant::with('assets')->findOrFail($id);
    }

    public function getDeliveryLocations(){
        return DeliveryLocation::get()->unique('name');
    }
}