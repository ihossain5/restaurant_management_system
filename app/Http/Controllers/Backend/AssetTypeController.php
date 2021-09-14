<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssetTypeRequest;
use App\Models\AssetType;
use Illuminate\Http\Request;

class AssetTypeController extends Controller {
    public function index() {
        $asset_types = AssetType::latest()->get();
        return view('admin.asset-type.asset_type', compact('asset_types'));
    }
    public function store(AssetTypeRequest $request) {
        $asset_type      = AssetType::create($request->validated());
        $data            = array();
        $data['message'] = 'Data added successfully';
        $data['name']    = $asset_type->name;
        $data['id']      = $asset_type->asset_type_id;
        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    public function show(Request $request) {
        $asset_type = AssetType::findorFail($request->id);
        return response()->json([
            'success' => true,
            'data'    => $asset_type,
        ]);
    }
    public function edit(Request $request) {
        $asset_type = AssetType::findorFail($request->id);
        return response()->json([
            'success' => true,
            'data'    => $asset_type,
        ]);
    }
    public function update(AssetTypeRequest $request) {
        // dd($request->all());
        $asset_type = AssetType::findorFail($request->hidden_id);
        $asset_type->update($request->validated());

        $data            = array();
        $data['message'] = 'Data updated successfully';
        $data['name']    = $asset_type->name;
        $data['id']      = $asset_type->asset_type_id;

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }
    public function destroy(Request $request){
        $asset_type = AssetType::findorFail($request->id)->delete();
        $data                = array();
        $data['message']     = 'Data deleted successfully';
        $data['id']          = $request->id;

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }
}
