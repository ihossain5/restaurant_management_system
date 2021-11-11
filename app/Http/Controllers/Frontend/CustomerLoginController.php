<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class CustomerLoginController extends Controller {

    // public function __construct() {
    //     $this->middleware('guest')->except('logout');
    // }

    // Google login
    public function redirectToGoogle() {
         session()->put('previous_url', url()->previous());
        return Socialite::driver('google')->with(["prompt" => "select_account"])->redirect();
    }

    // Google callback
    public function handleGoogleCallback() {
        $user = Socialite::driver('google')->user();
        $this->_registerOrLoginUser($user);
        // Return home after login
       return  $this->redirectCustomer();
    }
    // facebook login
    public function redirectToFacebook() {
        session()->put('previous_url', url()->previous());
        return Socialite::driver('facebook')->redirect();
    }

    // facebook callback
    public function handleFacebookCallback() {
        $user = Socialite::driver('facebook')->user();
        $this->_registerOrLoginUser($user);
        // Return home after login
        return  $this->redirectCustomer();
    }

    protected function _registerOrLoginUser($data) {
        $user = Customer::where('email', '=', $data->email)->first();
        if (!$user) {
            $user              = new Customer();
            $user->name        = $data->name;
            $user->email       = $data->email;
            $user->save();
        }

        Auth::guard('customer')->login($user);
    }

    protected function redirectCustomer(){
        if(Auth::guard('customer')->user()->is_banned == 1){
            Auth::guard('customer')->logout();
            return redirect()->route('frontend.customer.sign.in')->with('error','Sorry! You have no permission to access this');
            // return response()->json([
            //     'success'=>false,
            //     'message'=> 'Sorry! You have no permission to access this',
            // ]);
        }else{
            Session::flash('message', 'Successfully logged in');
            if(session()->get('previous_url') == route('frontend.chekout')){
                $url= route('frontend.chekout');
            }else{
                $url= route('frontend.index');
            }
            session()->forget('previous_url');
            return redirect()->to($url);
            
        }
      
    }

}
