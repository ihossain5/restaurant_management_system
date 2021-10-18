<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemComboStoreRequest;
use App\Http\Requests\ItemComboUpdateReqeuest;
use App\Models\Combo;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ItemComboController extends Controller {
    public function index($id) {
        $restaurant  = Restaurant::find($id);
        $restaurants = Restaurant::get();
        $items       = $restaurant->restaurant_items;
        $allCombos   = [];
        foreach ($items as $item) {
            foreach ($item->combos as $combo) {
                $allCombos[] = $combo;
            }

        }
        $combos = collect($allCombos)->unique('combo_id');
        // dd($combos);
        return view('admin.item-management.item_combo', compact('restaurant', 'restaurants', 'items', 'combos'));
    }
    public function store(ItemComboStoreRequest $request) {
        $combo = Combo::create($request->validated());
        $photo = $request->photo;
        if ($photo) {
            $path      = 'item-combos/';
            $photo_url = storeImage($photo, $path, 401, 296);
        }
        $combo->update([
            'photo' => $photo_url,
        ]);
        foreach ($request->item as $item) {
            $combo->items()->attach([$item]);
        }

        $item = [];
        foreach ($combo->items as $item_combo) {
            $item[] = $item_combo->name;
        }

        $data              = array();
        $data['message']   = 'Item combo created successfully';
        $data['name']      = $combo->name;
        $data['image']     = $combo->photo;
        $data['item_name'] = $item;
        $data['price']     = $combo->price;
        $data['combo_id']  = $combo->combo_id;
        return success($data);

    }

    public function edit(Request $request) {
        $combo = Combo::with('items')->findOrFail($request->id);
        return success($combo);
    }

    public function update(ItemComboUpdateReqeuest $request) {
        // dd($request->all());
        $combo = Combo::findOrFail($request->hidden_id);
        $photo = $request->photo;
        $combo->update($request->validated());
        if ($photo) {
            $path      = 'item-combos/';
            $photo_url = storeImage($photo, $path, 401, 296);
            $combo->update([
                'photo' => $photo_url,
            ]);
        }
        $combo->items()->sync($request->item);
        $item = [];
        foreach ($combo->items as $item_combo) {
            $item[] = $item_combo->name;
        }

        $data              = array();
        $data['message']   = 'Item combo updated successfully';
        $data['name']      = $combo->name;
        $data['image']     = $combo->photo;
        $data['item_name'] = $item;
        $data['price']     = $combo->price;
        $data['combo_id']  = $combo->combo_id;
        return success($data);
    }

    public function destroy(Request $request) {
        $combo = Combo::findOrFail($request->id);
        deleteImage($combo->photo);
        $combo->delete();
        $data             = array();
        $data['message']  = 'Item combo deleted successfully';
        $data['combo_id'] = $combo->combo_id;
        return success($data);
    }

    public function getComboByRestaurant(Request $request) {
        // dd($request->all());
        $restaurant = Restaurant::findOrFail($request->id);
        // $combos = Combo::all();
        // foreach($combos as $combo){
        //     $new_combo = [];
        //     foreach($combo->items as $item){
        //         if($item->category->restaurant->restaurant_id == $restaurant->id){
        //             $new_combo[] = $item->combos;
        //         }
        //     }
        // }
        // dd($new_combo);
        setSession($request->id);
        $items       = $restaurant->restaurant_items;
        $allCombos   = [];
        $combo_items = [];
        foreach ($items as $item) {
            foreach ($item->combos as $combo) {
                $allCombos[]   = $combo;

            }

        }
        $combos = collect($allCombos)->unique('combo_id');

        foreach ($combos as $item_combo) {
            $combo_items[] =  $item_combo->load('items');
        }

        $data                = [];
        $data['id']          = $request->id;
        $data['name']        = $restaurant->name;
        $data['session_id']  = Session::get('restaurant_id');
        $data['items']       = $items;
        $data['combos']      = $combos;
        $data['combo_items'] = $combo_items;
        return success($data);
    }
}
