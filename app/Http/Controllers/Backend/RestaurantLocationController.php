<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\RestaurantDeliveryLocationRequest;
use App\Models\DeliveryLocation;
use App\Models\Restaurant;
use App\Models\RestaurantDeliveryLocation;
use Illuminate\Http\Request;

class RestaurantLocationController extends Controller {
    public function index() {
        $restaurant_loations = RestaurantDeliveryLocation::with('location', 'restaurant')->latest()->get();
        $locations           = DeliveryLocation::all();
        $restaurants         = Restaurant::all();
        return view('admin.location.restaurant_location', compact('restaurant_loations', 'locations', 'restaurants'));
    }

    public function store(RestaurantDeliveryLocationRequest $request) {
        $data                       = new RestaurantDeliveryLocation();
        $data->restaurant_id        = $request->restaurant_id;
        $data->delivery_location_id = $request->location_id;
        $data->delivery_fee         = $request->delivery_fee;
        $data->save();
        $data->load('restaurant', 'location');
        $data['message']        = 'Delivery charge added successfully';
        $data['deliveryCharge'] = currency_format($data->delivery_fee);
        return success($data);
    }

    public function edit(RestaurantDeliveryLocation $location) {
        return success($location);
    }

    public function update(RestaurantDeliveryLocationRequest $request) {
        $location                       = RestaurantDeliveryLocation::findOrFail($request->hidden_id);
        $location->restaurant_id        = $request->restaurant_id;
        $location->delivery_location_id = $request->location_id;
        $location->delivery_fee         = $request->delivery_fee;
        $location->save();

        $data['message']        = 'Delivery charge updated successfully';
        $data['deliveryCharge'] = currency_format($request->delivery_fee);
        $data['restaurant']     = Restaurant::find($request->restaurant_id);
        $data['location']       = DeliveryLocation::find($request->location_id);
        $data['id']             = $request->hidden_id;
        return success($data);

    }

    public function destroy(Request $request) {
        $location        = RestaurantDeliveryLocation::findOrFail($request->id)->delete();
        $data['message'] = 'Delivery charge deleted successfully';
        $data['id']      = $request->id;
        return success($data);
    }
}
