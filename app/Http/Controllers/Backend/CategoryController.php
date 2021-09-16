<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class CategoryController extends Controller {
    public function index() {
        $new_restaurant = Restaurant::latest()->first();
        // $restaurants = Restaurant::where('restaurant_id', '!=', $new_restaurant->restaurant_id)->get();
        $restaurants = Restaurant::get();
        $categories  = $new_restaurant->restaurant_categories;
        foreach ($categories as $category) {
            $description                    = substr($category->description, 0, 25);
            $category->formated_description = $description;
        }
        return view('admin.item-management.item_category', compact('categories', 'new_restaurant', 'restaurants'));
    }

    public function store(CategoryRequest $request) {
        $category                         = Category::create($request->validated());
        $description                      = substr($category->description, 0, 25);
        $category['message']              = 'Category created successfully';
        $category['formated_description'] = $description;
        return success($category);
    }

    public function show(Request $request) {
        $category = Category::findOrFail($request->id);
        return success($category);
    }

    public function edit(Request $request) {
        $category = Category::findOrFail($request->id);
        return success($category);
    }

    public function update(CategoryRequest $request) {
        $category = Category::findOrFail($request->hidden_id);
        $category->update($request->validated());
        $description                      = substr($category->description, 0, 25);
        $category['message']              = 'Category updated successfully';
        $category['formated_description'] = $description;
        return success($category);
    }

    public function destroy(Request $request) {
        $category        = Category::findOrFail($request->id)->delete();
        $data            = [];
        $data['id']      = $request->id;
        $data['message'] = 'Category deleted successfully';
        return success($data);
    }

    public function getCategoriesByRestaurant(Request $request) {
        $restaurant = Restaurant::findOrFail($request->id);
        $categories = $restaurant->restaurant_categories;
        $data            = [];
        $data['id']      = $request->id;
        $data['categories']      = $categories;
        return success($data);
    }

}
