<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function index(){
        $restaurants = Restaurant::all();
        return view('frontend.contact-us.contact_us',compact('restaurants'));
    }
}
