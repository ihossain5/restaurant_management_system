<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class CustomerLoginController extends Controller {

    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    // Google login
    public function redirectToGoogle() {
        return Socialite::driver('google')->with(["prompt" => "select_account"])->redirect();
    }

    // Google callback
    public function handleGoogleCallback() {
        $user = Socialite::driver('google')->user();
        $this->_registerOrLoginUser($user);

        // Return home after login
        return redirect()->route('frontend.index');
    }

    protected function _registerOrLoginUser($data) {
        $user = Customer::where('email', '=', $data->email)->first();
        if (!$user) {
            $user              = new Customer();
            $user->name        = $data->name;
            $user->email       = $data->email;
            // $user->provider_id = $data->id;
            // $user->avatar      = $data->avatar;
            $user->save();
        }

        Auth::guard('customer')->login($user);
    }

}
