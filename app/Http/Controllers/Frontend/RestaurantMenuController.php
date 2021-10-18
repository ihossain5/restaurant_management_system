<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantMenuController extends Controller
{
    public function getRestaurant(Restaurant $restaurant){
        $restaurant->load('assets','restaurant_categories','restaurant_categories.items');    
        return view('frontend.restaurant.restaurant_menu', compact('restaurant'));
    }
}
