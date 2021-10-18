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
        $restaurants = Restaurant::all();
        return view('frontend.about-us.about_us',compact('about','restaurants'));
    }
}
