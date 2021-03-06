<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DeliveryLocation;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RestaurantMenuController extends Controller
{
    public function getRestaurant(Restaurant $restaurant){
        $locations =  DeliveryLocation::orderBy('name','ASC')->get()->unique('name');
        $restaurant->load('assets','restaurant_categories','restaurant_categories.available_items','status','delivery_locations');
        $restaurant_locations= $restaurant->delivery_locations->pluck('name');  
        $images=[];
        if (Session::has('restaurantIds')){
            if (in_array($restaurant->restaurant_id, Session::get('restaurantIds')->toArray())) {
                $restaurant->disable = false;
            } else {
                $restaurant->disable = true;
            } 
        }
        // dd($restaurant);
  
        foreach($restaurant->assets as $asset){
            
            if($asset->pivot->section == 'menu'){
                $images[] = $asset->pivot->asset;
            }
        }  
        // return view('frontend.restaurant.restaurant_menu', compact('restaurant','images','locations','restaurant_locations'));
        return view('frontend.restaurant.restaurant_menu_new', compact('restaurant','images','locations','restaurant_locations'));
    }
}
