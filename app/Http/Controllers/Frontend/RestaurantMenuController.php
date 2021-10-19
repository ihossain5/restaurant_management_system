<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantMenuController extends Controller
{
    public function getRestaurant(Restaurant $restaurant){
        $restaurant->load('assets','restaurant_categories','restaurant_categories.items');  
        $images=[];
        foreach($restaurant->assets as $asset){
            if($asset->pivot->section == 'menu'){
                $images[] = $asset->pivot->asset;
            }
        }  
        return view('frontend.restaurant.restaurant_menu', compact('restaurant','images'));
    }
}
