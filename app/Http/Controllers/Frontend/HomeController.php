<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Combo;
use App\Models\HomeHeroSection;
use App\Models\Item;
use App\Models\Restaurant;
use Carbon\Carbon;
use Cart;
class HomeController extends Controller {
    public function index() {
        // dd(Cart::content());
        $sliders     = HomeHeroSection::all();
        $restaurants = Restaurant::with('assets')->where('is_open', 1)->latest()->get();
        foreach ($restaurants as $restaurant) {
            foreach ($restaurant->assets as $asset) {
                if($asset->pivot->section == 'home'){
                    $restaurant->asset = $asset->pivot->asset;
                    break;
                }
            
            }
        }
        $order_items = Item::where('is_available', 1)->with(['category','orders' => function ($query) {
            $query->whereMonth('orders.created_at', '=', Carbon::now()->subMonth()->month)
                  ->where('order_status_id', 3);
        }])->limit(12)->get();

        $combos = Combo::with('items')->where('is_available', 1)->get();
        foreach($combos as $combo){
            foreach($combo->items as $item){
                $combo->restaurant  = $item->category->restaurant->name;
                $combo->restaurant_id  = $item->category->restaurant->restaurant_id;
            }
        }
        return view('frontend.index', compact('sliders', 'restaurants','order_items','combos'));
    }
}
