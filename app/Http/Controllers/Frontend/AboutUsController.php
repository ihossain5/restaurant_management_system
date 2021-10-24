<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\DeliveryLocation;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index(){
        $about = AboutUs::first();
        $restaurants = Restaurant::with('assets')->get();
        $locations =  DeliveryLocation::get()->unique('name');
        foreach ($restaurants as $restaurant) {
            $strip_text  = strip_tags($restaurant->description);
            $result      = preg_replace('/<(\w+)[^>]*>/', '<$1>', $strip_text);
            $restaurant->formated_description = $result;
            $data = [];
            foreach ($restaurant->assets as $asset) {
                if($asset->pivot->section == 'about_us'){
                    $data[] = $asset->pivot->asset;
                }
            
            }
            $restaurant->images = $data;
        }
        return view('frontend.about-us.about_us',compact('about','restaurants','locations'));
    }
}
