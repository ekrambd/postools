<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Auth;
use Image;
use File;
class SettingsController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth_check');
    }
    public function ChangePassword()
    {
    	return view('password_change');
    }

    public function PasswordChange(Request $request)
    {
    	$id = Auth::user()->id;
    	$user = DB::table('users')->where('id',$id)->first();
    	if(Hash::check($request->current_password,$user->password)){
    		DB::table('users')
    		  ->where('id',$id)
    		  ->update(['password' => bcrypt($request->new_password)]);
    		   $notification=array(
                     'messege'=>'Successfully Password Changed ',
                     'alert-type'=>'success'
                    );
                return Redirect()->back()->with($notification);
    	}else{
    		$notification=array(
                     'messege'=>'Sorry Current Password is Invalid ',
                     'alert-type'=>'error'
                    );
                return Redirect()->back()->with($notification);
    	}
    }
    public function ProfileSettings()
    {   
    	$id = Auth::user()->id;
    	$user = DB::table('users')->where('id',$id)->first();
    	return view('profile_settings', compact('user'));
    }

    public function UpdateProfile(Request $request,$id)
    {
    	$user = DB::table('users')->where('id',$id)->first();
    	$data = array();
    	$data['name'] = $request->name;
    	$data['email'] = $request->email;
    	$image_one = $request->file('profile_pic');
    	if($image_one){
           $image_one_name= hexdec(uniqid()).'.'.$image_one->getClientOriginalExtension();
                Image::make($image_one)->resize(270,270)->save('upload/profile/'.$image_one_name);
                $data['profile_pic']='upload/profile/'.$image_one_name;
             if($user->profile_pic !== NULL){
             	 File::delete($user->profile_pic);
             }
             
        }
        else{
          $data['profile_pic'] = $user->profile_pic;
        } 
       DB::table('users')->where('id',$id)->update($data);
       $notification=array(
                     'messege'=>'Successfully Profile Updated ',
                     'alert-type'=>'success'
                    );
                return Redirect()->back()->with($notification);
    }
}
