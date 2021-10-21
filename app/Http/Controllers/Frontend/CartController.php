<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Cart;

class CartController extends Controller {
    public function addToCart(Request $request) {
        // dd($request->all());
        // Cart::destroy();
        $product = Item::find($request->item_id); 
        Cart::add($product->item_id, $product->name, 1, $product->price)
        ->associate('App\Models\Item');

        $data = [];
        $data['message'] = 'Item has been added into cart';
        $data['items'] = Cart::content();
        $data['grandTotal'] = Cart::subtotal();
        return  response()->json([
            'success'=> true,
            'data'=> $data,
        ]);
    }
    public function updateCart(Request $request){
        $product = Item::find($request->item_id); 
        Cart::add($product->item_id, $product->name, 1, $product->price)
        ->associate('App\Models\Item');

        $data = [];
        $data['message'] = 'cart has been updated';
        $data['grandTotal'] = Cart::subtotal();
        $data['price'] = $product->price;
        return  response()->json([
            'success'=> true,
            'data'=> $data,
        ]);
    }
    public function decreaseCartQuantity(Request $request){
        $cart = Cart::content()->where('id',$request->item_id); 
        foreach($cart as $item){
            Cart::update($item->rowId, $request->quantity);
        }
        $data = [];
        $data['message'] = 'cart has been updated';
        $data['grandTotal'] = Cart::subtotal();
        // $data['price'] = $cart->price;
        return  response()->json([
            'success'=> true,
            'data'=> $data,
        ]);
    }

    public function deleteCart(Request $request){
        Cart::remove($request->rowId);
        $data = [];
        $data['grandTotal'] = Cart::subtotal();
        return  response()->json([
            'success'=> true,
            'data'=> $data,
        ]);
    }
}
