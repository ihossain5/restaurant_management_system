<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\ManagerStoreRequest;
use App\Http\Requests\ManagerUpdateRequest;
use App\Http\Requests\UserStoreRequest;
use App\Mail\SendMail;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ManagerController extends Controller {
    public function login() {
        if(!Auth::check()){
            return view('manager.manager_login');
        }else{
            return redirect()->route('manager.dashboard');
        }
       
    }
    public function singIn(LoginRequest $request) {
        $request->authenticate();
        $request->session()->regenerate();
        if (Auth::user()->is_manager == 1 && Auth::user()->is_active == 1) {
            return redirect()->route('manager.dashboard');
        } else {
            Auth::logout();
            return redirect()->back()->withErrors(['error' => 'Sorry! You have no permission to access this']);
        }
    }

    public function index() {
        $managers    = User::where('is_manager', 1)->latest()->get();
        $restaurants = Restaurant::where('user_id', null)->get();
        return view('admin.user_management.restaurant_managers', compact('managers', 'restaurants'));
    }

    public function store(ManagerStoreRequest $request) {
        $token = Str::random(30);
        $user  = User::create($request->validated() + [
            'password'   => $token,
            'token'      => $token,
            'is_manager' => 1,
        ]);
        $restaurant = Restaurant::where('restaurant_id', $request->restaurant)->update([
            'user_id' => $user->id,
        ]);
        $maildata = [
            'title'   => 'Geetings from Emerald',
            'message' => 'You are invited to use Emerald. You can now register here for free',
            'url'     => route('send.email', [$token]),
        ];

        Mail::to($request->email)->send(new SendMail($maildata));

        $data                    = [];
        $data['message']         = 'Manager added successfully';
        $data['name']            = $user->name;
        $data['email']           = $user->email;
        $data['contact']         = $user->contact ?? 'N/A';
        $data['photo']           = $user->photo;
        $data['sex']             = $user->sex ?? 'N/A';
        $data['id']              = $user->id;
        $data['restaurant_name'] = $user->restaurant->name;
        $data['restaurants']     = Restaurant::where('user_id', null)->get();

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }
    public function show(Request $request) {
        $manager = User::with('restaurant')->findOrFail($request->id);
        return response()->json([
            'success' => true,
            'data'    => $manager,
        ]);
    }
    public function edit(Request $request) {
        $manager = User::with('restaurant')->findOrFail($request->id);
        return response()->json([
            'success' => true,
            'data'    => $manager,
        ]);
    }

    public function update(ManagerUpdateRequest $request) {
        // dd($request->all());
        $user = User::findOrfail($request->hidden_id);
        $user->update($request->validated());
        $restaurant = Restaurant::where('restaurant_id', $request->restaurant)->first();
        if ($restaurant->user_id != null && $restaurant->user_id != $user->id) {
            $data            = [];
            $data['message'] = 'Manager has already assigned';
            return response()->json([
                'success' => false,
                'data'    => $data,
            ]);
        } else {
            $user->restaurant()->update([
                'user_id' => null,
            ]);
            $restaurant = Restaurant::where('restaurant_id', $request->restaurant)->update([
                'user_id' => $user->id,
            ]);

            $data                    = [];
            $data['message']         = 'Manager updated successfully';
            $data['name']            = $user->name;
            $data['email']           = $user->email;
            $data['contact']         = $user->contact ?? 'N/A';
            $data['photo']           = $user->photo;
            $data['sex']             = $user->sex ?? 'N/A';
            $data['id']              = $user->id;
            $data['restaurant_name'] = $user->restaurant->name;
            $data['restaurants']     = Restaurant::where('user_id', null)->get();
            return response()->json([
                'success' => true,
                'data'    => $data,
            ]);
        }

    }

    public function destroy(Request $request) {
        $manager         = User::findOrFail($request->id)->delete();
        Restaurant::where('user_id',$request->id)->update(['user_id'=>null]);
        $data            = [];
        $data['message'] = 'Manager deleted successfully';
        $data['id']      = $request->id;
        $data['restaurants']     = Restaurant::where('user_id', null)->get();
        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    public function registerNewManager($token) {
        // dd($token);
        $user = User::where('token', $token)->first();
        if ($user) {
            if ($user->is_verified == 0) {
                return view('admin.user_management.register', compact('user'));
            } else {
                abort('404');
            }
        } else {
            abort('404');
        }

    }

    public function userSignUp(UserStoreRequest $request) {
        $user  = User::where('email', $request->email)->first();
        $photo = $request->profile_image;
        if ($photo) {
            $path    = 'avatar/';
            $img_url = storeImage($photo, $path, 200, 200);
        }
        $user->update($request->validated() + [
            'token'       => null,
            'photo'       => $img_url,
            'is_verified' => 1,
        ]);
        if ($user) {
            Auth::login($user);
            if (Auth::user()->is_super_admin == 1 || Auth::user()->is_admin == 1 && Auth::user()->is_active == 1) {
                return redirect()->route('dashboard');
            } else if (Auth::user()->is_manager == 1) {
                return redirect()->route('manager.dashboard');
            } else {
                Auth::logout();
                return redirect()->back()->withErrors(['error' => 'Sorry! You have no permission to access this']);
            }

        }
    }
}
