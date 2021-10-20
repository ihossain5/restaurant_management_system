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

            foreach ($restaurant->assets as $asset) {
                $restaurant->asset = $asset->pivot->asset;
            }
            $file_type = File::extension($restaurant->asset);
        }
        return $restaurants;
    }

    public function getDeliveryLocations(){
        return DeliveryLocation::get()->unique('name');
    }
}