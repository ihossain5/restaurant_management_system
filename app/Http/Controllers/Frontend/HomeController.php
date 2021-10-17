<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\HomeHeroSection;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $sliders = HomeHeroSection::all();
        $restaurants = Restaurant::with('assets')->latest()->get();
        foreach ($restaurants as $restaurant) {
            foreach ($restaurant->assets as $asset) {
                $restaurant->asset = $asset->pivot->asset;
            }
        }
        return view('frontend.index',compact('sliders','restaurants'));
    }
}
