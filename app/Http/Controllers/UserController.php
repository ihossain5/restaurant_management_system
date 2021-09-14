<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
     public function allUser() {
        $users = User::where('is_super_admin','!=',1)->orderBy('id','DESC')->get();
        // dd($users);
        return view('admin.user_management.user', compact('users'));
    }

    public function changeAdminStatus(Request $request){
    	// dd($request->all());
    	  
      
            if ($request->value==1) {
		      $user    = User::findOrFail($request->id);
		       $user['is_admin'] = 1;
		        $user->update();

		    $data                = array();
            $data['message']     = 'Status changed successfully'; 
            $data['role']       = $user->is_admin==1?'Admin':'User';         
            $data['id']          = $user->id;
           

            return response()->json([
                'success' => true,
                'data'    => $data,
            ]);
		      }
		      else{
		      	
		        $user    = User::findOrFail($request->id);
		         $user['is_admin'] = 0;
		          $user->update();
			    $data                = array();
		        $data['message']     = 'Status changed successfully'; 
		        $data['role']       = $user->is_admin==1?'Admin':'User';         
		        $data['id']          = $user->id;
		      }
		     return response()->json([
                'success' => true,
                'data'    => $data,
            ]);
       
    }

    public function superAdmin(){
    	$users = User::orderBy('id','DESC')->get();
    	return view('admin.make_super_admin',compact('users'));
    }

    public function makeSuperAdmin(Request $request){
    	// dd($request->all());
    	  
      
            if ($request->value==1) {
		      $user    = User::findOrFail($request->id);
		       $user['is_super_admin'] = 1;
		       $user['is_admin'] = 1;
		        $user->update();

		    $data                = array();
            $data['message']     = 'Add super admin successfully';       
            $data['id']          = $user->id;
           

            return response()->json([
                'success' => true,
                'data'    => $data,
            ]);
		      }
		      else{
		      	
		        $user    = User::findOrFail($request->id);
		         $user['is_super_admin'] = 0;
		         $user['is_admin'] = 0;
		          $user->update();
			    $data                = array();
		        $data['message']     = 'Removed from super admin successfully'; 
		       
		      }
		     return response()->json([
                'success' => true,
                'data'    => $data,
            ]);
       
    }
}
