<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemStoreRequest;
use App\Http\Requests\ItemUpdateRequest;
use App\Models\Item;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class ItemController extends Controller {
    public function index() {
        $new_restaurant = Restaurant::latest()->first();
        $restaurants    = Restaurant::get();
        $items          = $new_restaurant->restaurant_items;
        $categories     = $new_restaurant->restaurant_categories;
        foreach ($items as $item) {
            foreach ($item->item_assets as $asset) {
                $item->asset = $asset->pivot->asset;
            }
        }
        return view('admin.item-management.item', compact('items', 'categories', 'new_restaurant', 'restaurants'));
    }

    public function store(ItemStoreRequest $request) {
        $photo = $request->photo;
        if ($photo) {
            $path      = 'item-assets/';
            $photo_url = storeImage($photo, $path, 480, 380);
        }
        $item = Item::create($request->validated());
        $item->item_assets()->attach([9 => [
            'asset' => $photo_url,
        ]]);
        $data             = array();
        $data['message']  = 'Item created successfully';
        $data['name']     = $item->name;
        $data['category'] = $item->category->name;
        $data['price']    = $item->price;
        $data['is_available']    = $item->is_available;
        $data['id']       = $item->item_id;

        foreach ($item->item_assets as $image) {
            $data['image'] = $image->pivot->asset;
        }
        return success($data);
    }
    public function edit(Request $request) {
        $item = Item::with('category', 'item_assets')->findOrFail($request->id);
        foreach ($item->item_assets as $asset) {
            $item->image = $asset->pivot->asset;
        }
        return success($item);
    }
    public function show(Request $request) {
        $item = Item::with('category', 'item_assets')->findOrFail($request->id);
        foreach ($item->item_assets as $asset) {
            $item->image = $asset->pivot->asset;
        }
        return success($item);
    }

    public function update(ItemUpdateRequest $request) {
        $item = Item::findOrFail($request->hidden_id);
        $photo = $request->photo;
        if ($photo) {
            foreach ($item->item_assets as $asset) {
                deleteImage($asset->pivot->asset);
            }
            $path      = 'item-assets/';
            $photo_url = storeImage($photo, $path, 480, 380);
        } else {
            foreach ($item->item_assets as $asset) {
                $photo_url = $asset->pivot->asset;
            }
        }
        $item->update($request->validated());
        $values[9] = [
            'asset' => $photo_url,
        ];
        $item->item_assets()->sync($values);

        $data             = array();
        $data['message']  = 'Item updated successfully';
        $data['name']     = $item->name;
        $data['category'] = $item->category->name;
        $data['price']    = $item->price;
        $data['is_available']    = $item->is_available;
        $data['id']       = $item->item_id;

        foreach ($item->item_assets as $image) {
            // dd($image);
            $data['image'] = $image->pivot->asset;
        }
        return success($data);

    }

    public function destroy(Request $request) {
        $item = Item::findOrFail($request->id);
        foreach ($item->item_assets as $asset) {
            deleteImage($asset->pivot->asset);
        }
        $item->delete();
        $data['message'] = 'Item deleted successfully';
        $data['id']      = $request->id;
        return success($data);
    }

    public function updateAvailableStatus(Request $request){
        $item = Item::findOrFail($request->id);
        if($item->is_available == 0){
            $item->update([
                'is_available'=> 1
            ]);
        }else{
            $item->update([
                'is_available'=> 0
            ]);
        }
        $data            = array();
        $data['message'] = 'Status updated successfully';
        $data['id']      = $item->item_id;
        return success($data);
    }

    public function getItemsByRestaurant(Request $request){
        $restaurant = Restaurant::findOrFail($request->id);
        $categories = $restaurant->restaurant_categories;
        $items = $restaurant->restaurant_items;
        foreach($items as $item){
            foreach($item->item_assets as $asset){
                $item->image = $asset->pivot->asset;
            }
        }
        $data            = [];
        $data['id']      = $request->id;
        $data['categories']      = $categories;
        $data['items']      = $items;
        return success($data);
    }
}
