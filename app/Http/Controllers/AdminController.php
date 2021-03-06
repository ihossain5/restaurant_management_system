<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminStoreRequest;
use App\Mail\SendMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminController extends Controller {
    public function adminLogin() {
        return view('admin.login');
    }
    public function index() {
        return view('admin.dashboard');
    }
    public function passwordChange() {
        return view('admin.password_change');
    }
    public function updatePassword(Request $request) {
        if (Auth::check()) {
            $data = $request->validate([
                'old_password' => 'required',
                'password'     => 'required|confirmed',
            ]);
            $currentPassword = Auth::User()->password;
            if (Hash::check($data['old_password'], $currentPassword)) {
                $userId         = Auth::User()->id;
                $user           = User::find($userId);
                $user->password = $data['password'];
                $user->save();
                if(Auth::user()->is_manager == 1){
                    Auth::logout();
                    return redirect()->route('manager.log.in')->with('message', 'Password change successfully. Please Login again');
                }else{
                    Auth::logout();
                    return redirect()->route('login')->with('message', 'Password change successfully. Please Login again');
                }
               
            } else {
                return back()->withErrors(['Sorry, your current password was not recognised. Please try again.']);
            }
        }
    }
    public function profile() {
        $user = Auth::user();
        return view('admin.profile_update', compact('user'));
    }
    public function profileUpdate(Request $request) {
        // dd($request->all());
        $user = Auth::user();
        $this->validate($request, [
            'name'  => 'required|max:100',
            'phone' => 'required|max:20',
            'email' => 'required|max:100|email|unique:users,email,' . $user->id,
            'image' => 'nullable|max:600|mimes:jpg,png,jpeg',

        ]);
        $image = $request->image;
        if ($image) {
            if ($user->image != null) {
                File::delete(public_path('images/' . $user->image));
            }
            $path    = 'avatar/';
            $image_url = storeImage($image, $path, 200, 200);
        } else {
            $image_url = $user->photo;
        }
        $user->update([
            'name'    => $request->name,
            'photo'   => $image_url,
            'contact' => $request->phone,
            'email'   => $request->email,

        ]);
        return redirect()->back()->with('success', 'Profile has been updated');
    }

    public function allAdmin() {
        $users = User::where('is_admin', 1)
            ->where('id', '!=', auth()->user()->id)
            ->orderBy('id', 'DESC')->get();
        return view('admin.user_management.admin', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminStoreRequest $request) {
        $adminStatus = $this->adminAvailability();
        if ($adminStatus == true) {
            $token = Str::random(30);
            $user  = User::create($request->validated() + [
                'password'  => $token,
                'token'     => $token,
                'is_admin'  => 1,
                'is_active' => 1,
            ]);
            $maildata = [
                'title'   => 'Geetings from Emerald',
                'message' => 'You are invited to use Emerald. You can now register here for free',
                'url'     => route('send.email', [$token]),
            ];
            Mail::to($request->email)->send(new SendMail($maildata));
            $data              = array();
            $data['message']   = 'Admin added successfully';
            $data['name']      = $user->name;
            $data['email']     = $user->email;
            $data['contact']   = $user->contact ?? 'N/A';
            $data['photo']     = $user->photo;
            $data['sex']       = $user->sex ?? 'N/A';
            $data['id']        = $user->id;
            $data['is_active'] = $user->is_active;
            return success($data);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'You have no permission to create an admin',
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request) {
        $data = User::findOrFail($request->id);

        if ($data) {

            return response()->json([
                'success' => true,
                'data'    => $data,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data'    => 'No information found',
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {
        $data = User::findOrFail($request->id);
        if ($data) {

            return response()->json([
                'success' => true,
                'data'    => $data,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data'    => 'No information found',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $employee  = User::findOrFail($request->hidden_id);
        $validator = Validator::make($request->all(), [
            'name'          => 'required|max:50',
            'email'         => 'required|max:50|email|unique:users,email,' . $employee->id,
            'phone'         => 'required|max:50',
            'profile_image' => 'nullable|max:600|mimes:jpg,png,jpeg|dimensions:width=200px,height=200px',
        ]);
        if ($validator->fails()) {
            $data          = array();
            $data['error'] = $validator->errors()->all();
            return response()->json([
                'success' => false,
                'data'    => $data,
            ]);
        } else {

            $profile_image = $request->profile_image;

            if ($profile_image) {
                File::delete(public_path('images/' . $employee->image));
                $profile_image_name = hexdec(uniqid());
                $profile_image_ext  = strtolower($profile_image->getClientOriginalExtension());

                $profile_image_image_full_name = $profile_image_name . '.' . $profile_image_ext;
                $profile_image_upload_path     = 'avatar/';
                $profile_image_upload_path1    = 'images/avatar';
                $profile_image_image_url       = $profile_image_upload_path . $profile_image_image_full_name;
                $success                       = $profile_image->move($profile_image_upload_path1, $profile_image_image_full_name);
                // $img = Image::make($image)->resize(680, 437);
                // $img->save($upload_path1 . $image_full_name, 60);
            } else {
                $profile_image_image_url = $employee->image;
            }
            $employee->update([
                'name'     => $request->name,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'image'    => $profile_image_image_url,
                'is_admin' => $request->is_admin ?? 0,
            ]);

            $data = array();
            // $data['message']     = 'Data has been updated.';
            // $data['name']        = $employee->name;
            // $data['email']       = $employee->email;
            // $data['phone']       = $employee->phone;
            // $data['id']          = $employee->id;
            $data['message']     = $employee->is_admin == 1 ? 'Admin info updated successfully' : 'User info updated successfully';
            $data['image']       = $employee->image;
            $data['name']        = $employee->name;
            $data['email']       = $employee->email;
            $data['phone']       = $employee->phone;
            $data['role']        = $employee->is_admin == 1 ? 'Admin' : 'User';
            $data['id']          = $employee->id;
            $data['super_admin'] = Auth::user()->is_super_admin;

            return response()->json([
                'success' => true,
                'data'    => $data,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
        $adminStatus = $this->adminAvailability();
        if ($adminStatus == true) {
            $employee = User::findOrFail($request->id);
            if ($employee->id == auth()->user()->id) {
                return response()->json([
                    'message' => 'You can not delete your own data',
                ]);
            } else {
                $employee->delete();
                File::delete(public_path('images/' . $employee->photo));
                $data['message'] = 'Admin deleted successfully';
                $data['id']      = $request->id;

                return response()->json([
                    'success' => true,
                    'data'    => $data,
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'You have no permission to delete an admin',
            ]);
        }

    }

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

        Mail::send('password_reset_mail', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('success', 'We have e-mailed your password reset link!');
    }
    public function showResetPasswordForm($token) {
        return view('admin.recover_password', ['token' => $token]);
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

        return redirect('/')->with('success', 'Your password has been changed!');
    }

    public function updateActiveStatus(Request $request) {
        $admin = User::findOrFail($request->id);
        if ($admin->is_active == 0) {
            $admin->update([
                'is_active' => 1,
            ]);
        } else {
            $admin->update([
                'is_active' => 0,
            ]);
        }
        $data            = [];
        $data['message'] = 'Status has been updated';
        return success($data);
    }

    protected function adminAvailability() {
        if (auth()->user()->is_super_admin == 1) {
            return true;
        } else {
            return false;
        }
    }
}
