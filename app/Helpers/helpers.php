<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManagerStatic as Image;

// store image
function storeImage($image, $path, $width, $height) {
    $image_name      = hexdec(uniqid());
    $ext             = strtolower($image->getClientOriginalExtension());
    $image_full_name = $image_name . '.' . $ext;
    $upload_path     = $path;
    $upload_path1    = 'images/' . $path;
    $image_url       = $upload_path . $image_full_name;
    $success         = $image->move($upload_path1, $image_full_name);
    // Image::configure(array('driver' => 'imagick'));
    // $img             = Image::make($image)->resize($width, $height);
    // // Image::make($image)->resize($width, $height,  function ($constraint) {
    // //     $constraint->aspectRatio();
    // // })->save($upload_path1.$image_full_name);

    // $img->save($upload_path1 . $image_full_name, 75);

    return $image_url;
}

// delete image

function deleteImage($image) {
    File::delete('images/' . $image);
}

// succes function
function success($data) {
    return response()->json([
        'success' => true,
        'data'    => $data,
    ]);
}

// format date
function formatDate($date) {
    return Carbon::parse($date)->format('d/m/Y');
//   return date('d/m/Y', strtotime($date));
}

// inject orders into item
 function ordersByRestaurant($restaurant) {
    foreach ($restaurant->restaurant_items as $item) {
        $restaurant->all_orders = $item->orders;
    }
    return $restaurant;
}

// set session 
 function setSession($restaurant_id)
{
    if (Session::has('restaurant_id')) {
        Session::forget('restaurant_id');
    }
    Session::put('restaurant_id', $restaurant_id);
}
