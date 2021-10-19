<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index(){
        $about = AboutUs::first();
        $restaurants = Restaurant::with('assets')->get();
       
        foreach ($restaurants as $restaurant) {
            $data = [];
            foreach ($restaurant->assets as $asset) {
                if($asset->pivot->section == 'about_us'){
                    $data[] = $asset->pivot->asset;
                }
            
            }
            $restaurant->images = $data;
        }
        return view('frontend.about-us.about_us',compact('about','restaurants'));
    }
}
