<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManagerStatic as Image;

// store image
function storeImage($image, $path, $height, $width){
    $image_name = hexdec(uniqid());
    $ext        = strtolower($image->getClientOriginalExtension());
    $image_full_name = $image_name . '.' . $ext;
    $upload_path     = $path;
    $upload_path1    = 'images/'.$path;
    $image_url       = $upload_path . $image_full_name;
    $img = Image::make($image)->resize($height, $width);
    $img->save($upload_path1 . $image_full_name, 60);

    return $image_url;
}

// delete image 

function deleteImage($image){
    File::delete('images/'.$image);
}

// succes function 
function success($data) {
    return response()->json([
        'success' => true,
        'data'    => $data,
    ]);
}



