<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller {
    public function showForgetPasswordForm() {
        return view('admin.forgot_password');
    }
    public function submitForgetPasswordForm(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users',
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
            'url'     => route('reset.password.get', [$token]),
        ];

        Mail::to($request->email)->send(new ForgotPasswordMail($maildata));

        return back()->with('success', 'We have e-mailed your password reset link!');
    }
    public function showResetPasswordForm($token) {
        $user = DB::table('password_resets')
        ->where('token', $token)
        ->first();
        return view('admin.recover_password', compact('user'));
    }
    public function submitResetPasswordForm(Request $request) {
        // dd($request->all());
        $request->validate([
            'email'                 => 'required|email|exists:users',
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
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

        $user = User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);
         DB::table('password_resets')->where(['email' => $request->email])->delete();


        if (Auth::attempt($request->only('email', 'password'))) {
            Session::flash('success','Password has been reset successfully');
            if (Auth::user()->is_manager == 1 && Auth::user()->is_active == 1) {
                return redirect()->route('manager.dashboard');
            } else {
                return redirect()->route('dashboard');
            }
        }

    }
}
