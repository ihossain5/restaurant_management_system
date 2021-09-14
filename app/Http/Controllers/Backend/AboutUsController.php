<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutUsUpdateRequest;
use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index() {
        $abouts = AboutUs::latest()->get();
        foreach ($abouts as $about) {
            $description                            = substr($about->description, 0, 25);
            $about->formated_description = $description;
        }
        return view('admin.about-us.about_us',compact('abouts'));
    }



    public function show(Request $request){
        $about_us = AboutUs::findorFail($request->id);
        return response()->json([
            'success' => true,
            'data'    => $about_us,
        ]);
    }
    public function edit(Request $request){
        $about_us = AboutUs::findorFail($request->id);
        return response()->json([
            'success' => true,
            'data'    => $about_us,
        ]);
    }

    public function update(AboutUsUpdateRequest $request){
        // dd($request->all());
        $about_us = AboutUs::findorFail($request->hidden_id);
        $image = $request->pic;
        if ($image) {
            $path      = 'about-us/';
            $image_url = storeImage($image, $path, 550, 485);
        }else{
            $image_url  = $about_us->pic;
        }
        $about_us->update([
            'heading'     => $request->heading,
            'description' => $request->description,
            'pic'         => $image_url,
        ]);
        $description = substr($about_us->description, 0, 25);

        $data                = array();
        $data['message']     = 'Data updated successfully';
        $data['heading']     = $about_us->heading;
        $data['description'] = $description;
        $data['image']       = $about_us->pic;
        $data['id']          = $about_us->about_us_id;

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    public function destroy(Request $request){
        $hero_section = AboutUs::findorFail($request->id);
        deleteImage($hero_section->pic);
        $hero_section->delete();

        $data                = array();
        $data['message']     = 'Data deleted successfully';
        $data['id']          = $hero_section->id;

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }
}
