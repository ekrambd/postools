<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use Auth;
class AccessController extends Controller
{
    // public function AdminInsert()
    // {
    // 	return view('admin_insert');
    // }

    // public function InsertUser(Request $request)
    // {
    //     $data = $request->all();
    //     $user = new User;
    // 		$user->name = $data['name'];
    // 		$user->email = $data['email'];
    // 		$user->password = bcrypt($data['password']);
    // 		$user->save();
    //     return back();
    // }

    public function AdminLogin(Request $request)
    {
    	$data = $request->all();
        

    	if(Auth::attempt(['email'=> $data['email'], 'password'=>$data['password']])){
            
    		return redirect('/dashboard');
    	}else{
    		echo "False";
    	}
    }

    

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
