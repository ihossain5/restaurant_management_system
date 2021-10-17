<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantMenuController extends Controller
{
    public function getRestaurant(Restaurant $restaurant){
        // dd($restaurant);
        return view('frontend.restaurant.restaurant_menu');
    }
}
