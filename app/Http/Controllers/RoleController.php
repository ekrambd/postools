<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class RoleController extends Controller
{  
    public function __construct()
    {
        $this->middleware('auth_check');
    }
    public function AddUser()
    {
    	return view('add_user');
    }

    public function InsertUser(Request $request)
    {
        $email = $request->email;
        $count = DB::table('users')->where('email',$email)->count();
        if($count > 0){
        	$notification=array(
                     'messege'=>'Sorry, Already this user has been exist',
                     'alert-type'=>'error'
                    );
                return Redirect()->back()->with($notification);
        }else{

        	$data = array();
        	$data['name'] = $request->name;
        	$data['email'] = $request->email;
        	$data['password'] = bcrypt($request->password);
        	$data['role'] = $request->role;
        	$data['create_user'] = $request->create_user;
        	$data['pos'] = $request->pos;
        	$data['customer'] = $request->customer;
        	$data['supplier'] = $request->supplier;
        	$data['category'] = $request->category;
        	$data['product'] = $request->product;
        	$data['sale_product'] = $request->sale_product;
        	$data['set_order'] = $request->set_order;
        	$data['due_report'] = $request->due_report;
        	$data['sales_report'] = $request->sales_report;
        	$data['settings'] = $request->settings;
        	DB::table('users')->insert($data);
        	$notification=array(
                     'messege'=>'Successfully User Inserted ',
                     'alert-type'=>'success'
                    );
                return Redirect()->back()->with($notification);
        	 
        }
    }

    public function AllUser()
    {   
    	$all = DB::table('users')->where('role', '!=', 'admin')->orderBy('id', 'DESC')->get();
    	return view('all_user', compact('all'));
    }

    public function EditUser($id)
    {
    	$edit = DB::table('users')->where('id',$id)->first();
    	return view('edit_user', compact('edit'));
    }

    public function UpdateUser(Request $request,$id)
    {
    	$get_data = DB::table('users')->where('id', $id)->first();

        $count = DB::table('users')->where('email', '!=', $get_data->email)->where('email', $request->email)->count();
       if($count > 0){
        	$notification=array(
                     'messege'=>'Sorry, Already this user has been exist',
                     'alert-type'=>'error'
                    );
                return Redirect()->back()->with($notification);
        }else{

        	$data = array();
        	$data['name'] = $request->name;
        	$data['email'] = $request->email;
        	$data['password'] = $get_data->password;
        	$data['role'] = $request->role;
        	$data['create_user'] = $request->create_user;
        	$data['pos'] = $request->pos;
        	$data['customer'] = $request->customer;
        	$data['supplier'] = $request->supplier;
        	$data['category'] = $request->category;
        	$data['product'] = $request->product;
        	$data['sale_product'] = $request->sale_product;
        	$data['set_order'] = $request->set_order;
        	$data['due_report'] = $request->due_report;
        	$data['sales_report'] = $request->sales_report;
        	$data['settings'] = $request->settings;
        	DB::table('users')->where('id',$id)->update($data);
        	$notification=array(
                     'messege'=>'Successfully User Updated ',
                     'alert-type'=>'success'
                    );
                return Redirect()->back()->with($notification);
        	 
        }
    }

    public function DeleteUser($id)
    {
    	DB::table('users')->where('id',$id)->delete();
    	$notification=array(
                     'messege'=>'Successfully User Deleted ',
                     'alert-type'=>'success'
                    );
                return Redirect()->back()->with($notification);
    }
}
