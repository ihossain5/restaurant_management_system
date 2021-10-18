<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemStoreRequest;
use App\Http\Requests\ItemUpdateRequest;
use App\Models\Category;
use App\Models\Item;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ItemController extends Controller {

    public function index($id) {
        // dd( Session::get('restaurant_id'));
        $restaurant  = Restaurant::find($id);
        $restaurants = Restaurant::get();
        $items       = $restaurant->restaurant_items;
        $categories  = $restaurant->restaurant_categories;
        foreach ($items as $item) {
            foreach ($item->item_assets as $asset) {
                $item->asset = $asset->pivot->asset;
            }
        }
        return view('admin.item-management.item', compact('items', 'categories', 'restaurant', 'restaurants'));
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
        $data                 = array();
        $data['message']      = 'Item created successfully';
        $data['name']         = $item->name;
        $data['category']     = $item->category->name;
        $data['price']        = $item->price;
        $data['is_available'] = $item->is_available;
        $data['id']           = $item->item_id;

        foreach ($item->item_assets as $image) {
            $data['image'] = $image->pivot->asset;
        }
        return success($data);
    }
    public function edit(Request $request) {
        return success(Item::findItemById($request->id));
    }
    public function show(Request $request) {
        return success(Item::findItemById($request->id));
    }

    public function update(ItemUpdateRequest $request) {
        $item  = Item::findOrFail($request->hidden_id);
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
        $values[9] = [
            'asset' => $photo_url,
        ];
        $item->item_assets()->sync($values);
        $item->update($request->validated());

        $data                 = array();
        $data['message']      = 'Item updated successfully';
        $data['name']         = $item->name;
        $data['image']        = $photo_url;
        $data['category']     = $item->category->name;
        $data['price']        = $item->price;
        $data['is_available'] = $item->is_available;
        $data['id']           = $item->item_id;
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

    public function updateAvailableStatus(Request $request) {
        $item = Item::findOrFail($request->id);
        if ($item->is_available == 0) {
            $item->update([
                'is_available' => 1,
            ]);
        } else {
            $item->update([
                'is_available' => 0,
            ]);
        }
        $data            = array();
        $data['message'] = 'Status updated successfully';
        $data['id']      = $item->item_id;
        return success($data);
    }

    public function getItemsByRestaurant(Request $request) {
        $restaurant = Restaurant::findOrFail($request->id);
        if (Session::has('restaurant_id')) {
            Session::forget('restaurant_id');
        }
        Session::put('restaurant_id', $request->id);

        $categories = $restaurant->restaurant_categories;
        $items      = $restaurant->restaurant_items;
        foreach ($items as $item) {
            foreach ($item->item_assets as $asset) {
                $item->image = $asset->pivot->asset;
            }
        }
        $data               = [];
        $data['id']         = $request->id;
        $data['name']       = $restaurant->name;
        $data['session_id'] = Session::get('restaurant_id');
        $data['categories'] = $categories;
        $data['items']      = $items;
        return success($data);
    }

    // for manager
    public function itemsByManager() {
        $restaurant = auth()->user()->restaurant;
        $categories = $restaurant->restaurant_categories;
        $items      = $restaurant->restaurant_items;
        foreach ($items as $item) {
            foreach ($item->item_assets as $asset) {
                $item->image = $asset->pivot->asset;
            }
        }
        return view('manager.item.item', compact('items', 'categories'));
    }
    public function getItemsByCategory(Request $request) {
        if ($request->id == null) {
            $restaurant = auth()->user()->restaurant;
            $this->addImageIntoItems($restaurant->restaurant_items);
            $data['items'] = $restaurant->restaurant_items;
        } else {
            $category = Category::findOrFail($request->id);
            $this->addImageIntoItems($category->items);
            $data['items']         = $category->items;
            $data['category_name'] = $category->name;
        }
        return success($data);

    }
    public function addImageIntoItems($items) {
        foreach ($items as $item) {
            foreach ($item->item_assets as $asset) {
                $item->image = $asset->pivot->asset;
            }
        }
    }
}
