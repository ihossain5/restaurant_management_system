<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\HeroSectionStoreRequest;
use App\Http\Requests\HeroSectionUpdateRequest;
use App\Models\HomeHeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomeHeroSectionController extends Controller {
    public function index() {
        $hero_sections = HomeHeroSection::latest()->get();
        foreach ($hero_sections as $hero_section) {
            $description                            = substr($hero_section->description, 0, 25);
            $hero_section->formated_description = $description;
        }
        return view('admin.hero-section.hero_section',compact('hero_sections'));
    }

    public function store(HeroSectionStoreRequest $request) {
        $image = $request->pic;
        if ($image) {
            $path      = 'hero-section/';
            $image_url = storeImage($image, $path, 1920, 1080);
        }
        $hero_section = HomeHeroSection::create([
            'heading'     => $request->heading,
            'description' => $request->description,
            'pic'         => $image_url,
        ]);
        $description = substr($hero_section->description, 0, 25);

        $data                = array();
        $data['message']     = 'Data created successfully';
        $data['heading']     = $hero_section->heading;
        $data['description'] = $description;
        $data['image']       = $hero_section->pic;
        $data['id']          = $hero_section->home_hero_section_id;

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    public function show(Request $request){
        $hero_section = HomeHeroSection::findorFail($request->id);
        return response()->json([
            'success' => true,
            'data'    => $hero_section,
        ]);
    }
    public function edit(Request $request){
        // dd($request->all());
        $hero_section = HomeHeroSection::findorFail($request->id);
        return response()->json([
            'success' => true,
            'data'    => $hero_section,
        ]);
    }

    public function update(HeroSectionUpdateRequest $request){
        // dd($request->all());
        $hero_section = HomeHeroSection::findorFail($request->hidden_id);
        $image = $request->pic;
        if ($image) {
            $path      = 'hero-section/';
            $image_url = storeImage($image, $path, 1920, 1080);
        }else{
            $image_url  = $hero_section->pic;
        }
       $update_hero_section =  $hero_section->update([
            'heading'     => $request->heading,
            'description' => $request->description,
            'pic'         => $image_url,
        ]);
        $description = substr($hero_section->description, 0, 25);

        $data                = array();
        $data['message']     = 'Data updated successfully';
        $data['heading']     = $hero_section->heading;
        $data['description'] = $description;
        $data['image']       = $hero_section->pic;
        $data['id']          = $hero_section->home_hero_section_id;

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    public function destroy(Request $request){
        $hero_section = HomeHeroSection::findorFail($request->id);
        delteImage($hero_section->pic);
        $hero_section->delete();

        $data                = array();
        $data['message']     = 'Data deleted successfully';
        $data['id']          = $hero_section->home_hero_section_id;

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }
}
