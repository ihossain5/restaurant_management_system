<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryLocationRequest;
use App\Models\DeliveryLocation;
use Illuminate\Http\Request;

class LocationController extends Controller {
    public function index() {
        $locations = DeliveryLocation::latest()->get();
        return view('admin.location.delivery_location', compact('locations'));
    }

    public function store(DeliveryLocationRequest $request) {
        $location            = DeliveryLocation::create($request->validated());
        $location['message'] = 'Location created successfully';
        return success($location);
    }

    public function edit(DeliveryLocation $location) {
        return success($location);
    }

    public function update(DeliveryLocationRequest $request) {
        $location = DeliveryLocation::findOrFail($request->hidden_id)->update($request->validated());
        return $this->successResponse('updated', $request->name, $request->hidden_id);
    }

    public function destroy(Request $request) {
        $location = DeliveryLocation::findOrFail($request->id)->delete();
        return $this->successResponse('deleted', '', $request->id);
    }

    protected function successResponse($msg, $name, $id) {
        $data['message'] = 'Location ' . $msg . ' successfully';
        $data['name']    = $name;
        $data['id']      = $id;
        return success($data);
    }
}
