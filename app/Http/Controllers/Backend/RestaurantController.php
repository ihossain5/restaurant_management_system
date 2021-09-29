<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\RestaurantStoreRequest;
use App\Models\AssetRestaurant;
use App\Models\AssetType;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class RestaurantController extends Controller {
    public function index() {
        $asset_types = AssetType::get();
        $restaurants = Restaurant::with('assets')->latest()->get();
        foreach ($restaurants as $restaurant) {
            $description                      = substr($restaurant->description, 0, 25);
            $restaurant->formated_description = $description;
            foreach ($restaurant->assets as $asset) {
                $restaurant->asset = $asset->pivot->asset;
            }
            $file_type = File::extension($restaurant->asset);
        }
        return view('admin.restaurant.restaurants', compact('asset_types', 'restaurants'));
    }
    public function store(RestaurantStoreRequest $request) {
        $logo = $request->logo;
        if ($logo) {
            $path     = 'restaurant-logo/';
            $logo_url = storeImage($logo, $path, 80, 60);
        }
        $restaurant = Restaurant::create([
            'name'        => $request->name,
            'type'        => $request->type,
            'contact'     => $request->contact,
            'email'       => $request->email,
            'description' => $request->description,
            'address'     => $request->address,
            'logo'        => $logo_url,
        ]);
        $restaurant_assets = $request->asset;
        $this->storeAssets($restaurant_assets, $restaurant);
        $description = substr($restaurant->description, 0, 25);

        $data                = array();
        $data['message']     = 'Restaurant created successfully';
        $data['name']        = $restaurant->name;
        $data['address']     = $restaurant->address;
        $data['type']        = $restaurant->type;
        $data['is_open']     = $restaurant->is_open;
        $data['description'] = $description;
        $data['contact']     = $restaurant->contact;
        $data['email']       = $restaurant->email;
        $data['id']          = $restaurant->restaurant_id;

        foreach ($restaurant->assets as $image) {
            $data['image'] = $image->pivot->asset;
        }
        foreach ($restaurant->assets as $image) {
            $data['image']     = $image->pivot->asset;
            $data['file_type'] = File::extension($image->pivot->asset);
        }

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    public function show(Request $request) {
        $restaurant = Restaurant::with('assets')->findOrFail($request->id);
        return response()->json([
            'success' => true,
            'data'    => $restaurant,
        ]);
    }
    public function edit(Request $request) {
        $restaurant = Restaurant::with('assets')->findOrFail($request->id);
        foreach ($restaurant->assets as $asset) {
            $asset->id = $asset->pivot->asset_restaurant_id;
        }
        // dd($restaurant->assets);
        return response()->json([
            'success' => true,
            'data'    => $restaurant,
        ]);
    }
    public function update(RestaurantStoreRequest $request) {
        // dd($request->all());
        $restaurant = Restaurant::findOrFail($request->hidden_id);
        $logo       = $request->logo;
        if ($logo) {
            deleteImage($restaurant->logo);
            $path     = 'restaurant-logo/';
            $logo_url = storeImage($logo, $path, 80, 60);
        } else {
            $logo_url = $restaurant->logo;
        }
        $restaurant->update([
            'name'        => $request->name,
            'type'        => $request->type,
            'contact'     => $request->contact,
            'email'       => $request->email,
            'description' => $request->description,
            'address'     => $request->address,
            'logo'        => $logo_url,
        ]);
        $item_assets_old = $request->asset;
        $item_assets     = $request->new_asset;

        if ($item_assets_old) {

            foreach ($item_assets_old as $old_item_assets) {
                // dd();
                if (array_key_exists("asset", $old_item_assets)) {
                    $asset = $old_item_assets['asset'];
                    // dd($asset);
                    $file_type = $asset->getClientOriginalExtension();
                    if ($file_type == 'jpg' || $file_type == 'png' || $file_type == 'gif' || $file_type == 'webp') {

                        $image_name = hexdec(uniqid());
                        $ext        = strtolower($file_type);

                        $image_full_name = $image_name . '.' . $ext;
                        $upload_path     = 'restaurant-assets/';
                        $upload_path1    = 'images/restaurant-assets';

                        $url = $upload_path . $image_full_name;
                        // $success         = $logo->move($upload_path1, $image_full_name);
                        $success = $asset->move($upload_path1, $image_full_name);

                    } else {
                        $filename = time() . '.' . $file_type;
                        // $path     = '/backend/work/work_asset/video/';
                        $upload_path  = 'restaurant-assets/';
                        $upload_path1 = 'images/restaurant-assets/';
                        $url          = $upload_path . $filename;
                        $asset->move($upload_path1, $filename);

                    }

                    $asset = AssetRestaurant::where('asset_restaurant_id', $old_item_assets['id'])->first();
                    File::delete(public_path('/images/' . $asset->asset));

                    $asset_item = AssetRestaurant::where('asset_restaurant_id', $old_item_assets['id'])->update([
                        "restaurant_id" => $restaurant->restaurant_id,
                        "asset_type_id" => 9,
                        "asset"         => $url,

                    ]);

                } else {

                    $asset_item = AssetRestaurant::where('asset_restaurant_id', $old_item_assets['id'])->update([

                        "restaurant_id" => $restaurant->restaurant_id,
                        "asset_type_id" => 9,
                        // "url" => $url,
                        // "link" => $url,

                    ]);
                }

            }
        } else if ($item_assets) {
            foreach ($item_assets as $asset_new) {

                $asset = $asset_new['asset'];
                // dd();
                $file_type = $asset->getClientOriginalExtension();
                if ($file_type == 'jpg' || $file_type == 'png' || $file_type == 'gif' || $file_type == 'webp') {

                    $image_name = hexdec(uniqid());
                    $ext        = strtolower($file_type);

                    $image_full_name = $image_name . '.' . $ext;
                    $upload_path     = 'restaurant-assets/';
                    $upload_path1    = 'images/restaurant-assets/';
                    $url             = $upload_path . $image_full_name;
                    // $success         = $logo->move($upload_path1, $image_full_name);
                    $success = $asset->move($upload_path1, $image_full_name);

                } else {
                    $filename = time() . '.' . $file_type;
                    // $path     = '/backend/work/work_asset/video/';
                    $upload_path  = 'restaurant-assets/';
                    $upload_path1 = 'images/restaurant-assets';
                    $url          = $upload_path . $filename;
                    $asset->move($upload_path1, $filename);
                }

                // $new_work_asset=WorkAsset::create([
                //     'work_id'=> $work->id,
                //     'work_asset_type_id'=> $work_asset['work_asset_type_id'],
                //     'title'=> $work_asset['title'],
                //     'link'=> $url,
                // ]);
                // dd($work_asset['title']);

                $asset                = new AssetRestaurant();
                $asset->restaurant_id = $restaurant->restaurant_id;
                $asset->asset_type_id = 9;
                $asset->asset         = $url;
                $asset->save();

            }
        }

        $description         = substr($restaurant->description, 0, 25);
        $data                = array();
        $data['message']     = 'Restaurant updated successfully';
        $data['name']        = $restaurant->name;
        $data['address']     = $restaurant->address;
        $data['type']        = $restaurant->type;
        $data['is_open']     = $restaurant->is_open;
        $data['description'] = $description;
        $data['contact']     = $restaurant->contact;
        $data['email']       = $restaurant->email;
        $data['id']          = $restaurant->restaurant_id;

        foreach ($restaurant->assets as $image) {
            $data['image'] = $image->pivot->asset;
            $fileType      = File::extension($image->pivot->asset);
        }
        $data['file_type'] = $fileType;
        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);

    }
    // public function update(RestaurantStoreRequest $request){
    //     $restaurant = Restaurant::findOrFail($request->hidden_id);
    //     $restaurant_assets = $request->asset;
    //     $restaurant_new_assets = $request->new_asset;
    //     $restaurant->update($request->validated());
    //     // dd($restaurant_assets);
    //     // dd($request->all());
    //     foreach ($restaurant_assets as $restaurant_asset) {
    //         if(array_key_exists("asset", $restaurant_asset)){
    //             $asset     = $restaurant_asset['asset'];
    //             $file_type = $asset->getClientOriginalExtension();
    //             if ($file_type == 'jpg' || $file_type == 'png' || $file_type == 'gif' || $file_type == 'webp') {
    //                 $path = 'restaurant-assets/';
    //                 $url  = storeImage($asset, $path, 1080, 720);
    //             } else {
    //                 $filename     = time() . '.' . $file_type;
    //                 $upload_path  = 'restaurant-assets/';
    //                 $upload_path1 = 'images/restaurant-assets';
    //                 $url          = $upload_path . $filename;
    //                 $asset->move($upload_path1, $filename);
    //             }

    //             $restaurant_data = AssetRestaurant::where('asset_type_id', $restaurant_asset['asset_type_id'])->first();
    //             if($restaurant_data){
    //                 deleteImage($restaurant_data->asset);
    //             }
    //             $restaurant->assets()->detach();

    //             $values[$restaurant_asset['asset_type_id']] = [
    //                 'asset' => $url,
    //             ];
    //             $restaurant->assets()->attach($values);

    //                 // $asset_item = AssetRestaurant::where('asset_type_id', $restaurant_asset['asset_type_id'])
    //                 // ->where('restaurant_id',$restaurant->restaurant_id)
    //                 // ->update([
    //                 //     "asset_type_id" => $restaurant_asset['asset_type_id'],
    //                 //     "asset"         => $url,

    //                 // ]);
    //         }else{

    //             // foreach($restaurant->assets as $asset){
    //             //     $url = $asset->pivot->asset;

    //             //     $values[$restaurant_asset['asset_type_id']] = [
    //             //         'asset' => $url,
    //             //     ];
    //             //     $restaurant->assets()->sync($values,true);
    //             // }
    //             $values[] = $restaurant_asset['asset_type_id'];
    //             $restaurant->assets()->sync($values,true);
    //         }

    //     }
    //     if($restaurant_new_assets){
    //         $this->storeAssets($restaurant_new_assets, $restaurant);
    //     }

    //     $description = substr($restaurant->description, 0, 25);
    //     $data                = array();
    //     $data['message']     = 'Restaurant updated successfully';
    //     $data['name']        = $restaurant->name;
    //     $data['address']     = $restaurant->address;
    //     $data['type']        = $restaurant->type;
    //     $data['is_open']     = $restaurant->is_open;
    //     $data['description'] = $description;
    //     $data['contact']     = $restaurant->contact;
    //     $data['email']       = $restaurant->email;
    //     $data['id']          = $restaurant->restaurant_id;

    //     foreach ($restaurant->assets as $image) {
    //         $data['image'] = $image->pivot->asset;
    //         $fileType                      = File::extension($image->pivot->asset);
    //     }
    //     $data['file_type']   = $fileType;
    //     return response()->json([
    //         'success' => true,
    //         'data'    => $data,
    //     ]);

    // }
    public function destroy(Request $request) {
        $restaurant = Restaurant::findOrFail($request->id);
        foreach ($restaurant->assets as $asset) {
            deleteImage($asset->pivot->asset);
        }
        $restaurant->delete();
        $data['message'] = 'Restaurant deleted successfully';
        $data['id']      = $request->id;

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }
    public function deleteAsset(Request $request) {
        $asset = AssetRestaurant::findOrFail($request->id);
        deleteImage($asset->asset);
        $asset->delete();
        $data['id'] = $request->id;

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    public function storeAssets($restaurant_assets, $restaurant) {
        foreach ($restaurant_assets as $restaurant_asset) {
            $asset     = $restaurant_asset['asset'];
            $file_type = $asset->getClientOriginalExtension();
            if ($file_type == 'jpg' || $file_type == 'png' || $file_type == 'gif' || $file_type == 'webp') {
                $path = 'restaurant-assets/';
                $url  = storeImage($asset, $path, 1080, 720);
            } else {
                $filename     = time() . '.' . $file_type;
                $upload_path  = 'restaurant-assets/';
                $upload_path1 = 'images/restaurant-assets';
                $url          = $upload_path . $filename;
                $asset->move($upload_path1, $filename);
            }
            $restaurant->assets()->attach([9 => [
                'asset' => $url,
            ]]);
        }
    }

    public function updateStatus(Request $request){
        $restaurant = Restaurant::findOrFail($request->id);
        if($restaurant->is_open == 0){
            $restaurant->update([
                'is_open'=> 1
            ]);
        }else{
            $restaurant->update([
                'is_open'=> 0
            ]);
        }
        $data = [];
        $data['message']= 'Status has been updated';
        return success($data);
    }

    public function restaurantOverview($id) {
        // $restaurant = Restaurant::find($id);
        $restaurants         = Restaurant::get();
        $new_orders          = $this->newOrders($id);
        $ordersInPreparation = $this->ordersInPreparation($id);
        $ordersInDelivery    = $this->ordersInDelivery($id);
        $completedOrders     = $this->completedOrders($id);
        $cancelledOrders     = $this->cancelledOrders($id);

        $restaurant    = Restaurant::with(['restaurant_orders' => function ($query) {
            $query->whereDate('orders.created_at', DB::raw('CURDATE()'))->get();
        }])->find($id);
        $total_revenue = $restaurant->restaurant_orders->sum('amount');
        return view('admin.restaurant.restaurant_overview', compact(
            'restaurant', 'restaurants', 'new_orders', 'ordersInPreparation', 'ordersInDelivery', 'completedOrders', 'cancelledOrders', 'total_revenue'
        ));
    }

    public function orderReportByRestaurant(Request $request) {
        // dd($request->all());
        $new_orders          = $this->newOrders($request->id);
        // dd($new_orders);
        $ordersInPreparation = $this->ordersInPreparation($request->id);
        $ordersInDelivery    = $this->ordersInDelivery($request->id);
        $completedOrders     = $this->completedOrders($request->id);
        $cancelledOrders     = $this->cancelledOrders($request->id);

        $restaurant    = Restaurant::with(['restaurant_orders' => function ($query) {
            $query->whereDate('orders.created_at', DB::raw('CURDATE()'))->get();
        }])->find($request->id);
        $total_revenue = $restaurant->restaurant_orders->sum('amount');

        if (Session::has('restaurant_id')) {
            Session::forget('restaurant_id');
        }
        Session::put('restaurant_id', $request->id);

        $data                        = [];
        $data['id']                  = $request->id;
        $data['restaurant_name']                  = $restaurant->name;
        $data['session_id']          = Session::get('restaurant_id');
        $data['new_orders']          = $new_orders;
        $data['ordersInPreparation'] = $ordersInPreparation;
        $data['ordersInDelivery']    = $ordersInDelivery;
        $data['completedOrders']     = $completedOrders;
        $data['cancelledOrders']     = $cancelledOrders;
        $data['total_revenue']       = $total_revenue;
        return success($data);
    }

    public function newOrders($id) {
        $restaurant = Restaurant::with(['restaurant_orders' => function ($query) {
            $query->whereDate('orders.created_at', DB::raw('CURDATE()'))->get();
        }])->find($id);
        // dd();
        $count      = count($restaurant->restaurant_orders);
        return $count;
    }
    public function ordersInPreparation($id) {
        $restaurant = Restaurant::with(['restaurant_orders' => function ($query) {
            $query->whereDate('orders.created_at', DB::raw('CURDATE()'))
                ->where('orders.order_status_id', 1)->get();
        }])->find($id);
        $count      = count($restaurant->restaurant_orders);
        return $count;
    }
    public function ordersInDelivery($id) {
        $restaurant = Restaurant::with(['restaurant_orders' => function ($query) {
            $query->whereDate('orders.created_at', DB::raw('CURDATE()'))
            ->where('orders.order_status_id', 2)->get();
        }])->find($id);
        $count      = count($restaurant->restaurant_orders);
        return $count;
    }
    public function completedOrders($id) {
        $restaurant = Restaurant::with(['restaurant_orders' => function ($query) {
            $query->whereDate('orders.created_at', DB::raw('CURDATE()'))
            ->where('orders.order_status_id', 3);
        }])->find($id);
        $count      = count($restaurant->restaurant_orders);
        return $count;
    }
    public function cancelledOrders($id) {
        $restaurant = Restaurant::with(['restaurant_orders' => function ($query) {
            $query->whereDate('orders.created_at', DB::raw('CURDATE()'))
            ->where('orders.order_status_id', 4)->get();
        }])->find($id);
        $count      = count($restaurant->restaurant_orders);
        return $count;
    }

    public static function getRestaurantIdBySession(){
        $restaurant = Restaurant::first();
        $restaurant_id = Session::get('restaurant_id') ?? $restaurant->restaurant_id;
        return $restaurant_id;
    }

}
