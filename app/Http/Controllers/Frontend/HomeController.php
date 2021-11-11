<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\HomePageService;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller {
    public $homePageService;
    public function __construct(HomePageService $homePageService) {
        $this->homePageService = $homePageService;
    }
    public function index(HomePageService $homePageService) {
        $locations   = $homePageService->getDeliveryLocations();
        $sliders     = $homePageService->heroSlider();
        $restaurants = $homePageService->restaurants();
        $order_items = $homePageService->popularDishes();
        $combos      = $homePageService->combos();

        return view('frontend.index', compact('sliders', 'restaurants', 'order_items', 'combos', 'locations'));
    }

    public function getRestaurantsByLocation($id) {
        $location              = $this->homePageService->getRestaurantByLocation($id);
        if(count(Cart::content())>0){
            Cart::destroy();
        }
        $data['restaurants']   = $location->restaurants;
        $data['location_name'] = $location->name;
        return redirect()->back();
        // return success($data);
    }
}
