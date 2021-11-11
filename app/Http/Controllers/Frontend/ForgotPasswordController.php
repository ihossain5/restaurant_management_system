<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPasswordMail;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller {
    public function forgotPassword() {
        return view('frontend.customer.forgot-password');
    }
    public function submitForgetPasswordForm(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:customers',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email'      => $request->email,
            'token'      => $token,
            'created_at' => Carbon::now(),
        ]);
        $maildata = [
            'title'   => 'Hello',
            'message' => 'You are receiving this email because we are received a password reset request for your account',
            'url'     => route('customer.reset.password', [$token]),
        ];
        Mail::to($request->email)->send(new ForgotPasswordMail($maildata));

        return back()->with('success', 'We have e-mailed your password reset link!');
    }

    public function resetPassword($token) {
        $customer = DB::table('password_resets')
            ->where('token', $token)
            ->first();
        return view('frontend.customer.reset-password', compact('customer'));
    }

    public function submitResetPassword(Request $request) {
        // dd($request->all());
        $request->validate([
            'email'    => 'required|email|exists:customers',
            'password' => 'required|string|min:8',
        ]);

        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token,
            ])
            ->first();

        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $user = Customer::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
        // dd('sdsd');

        // DB::table('password_resets')->where(['email' => $request->email])->delete();
        $credentials = $request->only('email', 'password');
        if (Auth::guard('customer')->attempt($credentials)) {
            if(Auth::guard('customer')->user()->is_banned == 1){
                Auth::guard('customer')->logout();
                return redirect()->route('frontend.customer.sign.in')->with('error','Sorry, You have no permission to access this');
            }else{
                Session::flash('success', 'Password has been reset successfully');
                return redirect()->route('customer.profile');
            }

        }
    }
}
