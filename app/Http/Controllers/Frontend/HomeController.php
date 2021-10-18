<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Combo;
use App\Models\HomeHeroSection;
use App\Models\Item;
use App\Models\Restaurant;
use Carbon\Carbon;

class HomeController extends Controller {
    public function index() {
        $sliders     = HomeHeroSection::all();
        $restaurants = Restaurant::with('assets')->latest()->get();
        foreach ($restaurants as $restaurant) {
            foreach ($restaurant->assets as $asset) {
                $restaurant->asset = $asset->pivot->asset;
            }
        }
        $order_items = Item::where('is_available', 1)->with(['category','orders' => function ($query) {
            $query->whereMonth('orders.created_at', '=', Carbon::now()->subMonth()->month)
                  ->where('order_status_id', 3);
        }])->limit(12)->get();

        $combos = Combo::with('items')->get();
        foreach($combos as $combo){
            foreach($combo->items as $item){
                $combo->restaurant  = $item->category->restaurant->name;
            }
        }
        return view('frontend.index', compact('sliders', 'restaurants','order_items','combos'));
    }
}
