<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUsUpdateRequest;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function index(){
        $contacts = ContactUs::latest()->get();
        return view('admin.contact-us.contact_us',compact('contacts'));
    }
    
    public function show(Request $request){
        $contact_us = ContactUs::findorFail($request->id);
        return response()->json([
            'success' => true,
            'data'    => $contact_us,
        ]);
    }
    public function edit(Request $request){
        $contact_us = ContactUs::findorFail($request->id);
        return response()->json([
            'success' => true,
            'data'    => $contact_us,
        ]);
    }
    public function update(ContactUsUpdateRequest $request){
        // dd($request->all());
        $contact_us = ContactUs::findorFail($request->hidden_id);
        $contact_us->update($request->validated());

        $data                = array();
        $data['message']     = 'Data updated successfully';
        $data['contact']     = $contact_us->contact;
        $data['email']       = $contact_us->email;
        $data['id']          = $contact_us->contact_us_id;

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }
}
