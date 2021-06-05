<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Image;
use File;
class CustomerController extends Controller
{   
   public function __construct()
    {
        $this->middleware('auth_check');
    }
    public function AddCustomer()
    {
    	return view('add_customer');
    }

    public function InsertCustomer(Request $request)
    {
    	$data = array();
    	$data['customer_name'] = $request->customer_name;
    	$data['customer_email'] = $request->customer_email;
    	$data['customer_address'] = $request->customer_address;
    	$data['customer_phone'] = $request->customer_phone;

    	$image = $request->file('customer_image');
    	$image_one_name= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                Image::make($image)->resize(270,270)->save('upload/customer/'.$image_one_name);
         $data['customer_image']='upload/customer/'.$image_one_name;
        DB::table('customers')->insert($data);
        $notification=array(
                     'messege'=>'Successfully Customer Inserted ',
                     'alert-type'=>'success'
                    );
                return Redirect()->back()->with($notification); 
    }

    public function AllCustomer()
    {
    	$all = DB::table('customers')->orderBy('id', 'DESC')->get();
    	return view('all_customer', compact('all'));
    }

    public function EditCustomer($id)
    {
    	$edit = DB::table('customers')->where('id',$id)->first();
    	return view('edit_customer',compact('edit'));
    }

    public function UpdateCustomer(Request $request, $id)
    {   
    	$get_data = DB::table('customers')->where('id', $id)->first();
    	$data = array();
    	$data['customer_name'] = $request->customer_name;
    	$data['customer_email'] = $request->customer_email;
    	$data['customer_address'] = $request->customer_address;
    	$data['customer_phone'] = $request->customer_phone;
    	$image = $request->file('customer_image');
        if($image){
          $image_one_name= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
          $success = Image::make($image)->resize(270,270)->save('upload/customer/'.$image_one_name);
         
          if($success){
              $destinationPath = $get_data->customer_image;
              File::delete($destinationPath);
              $data['customer_image']='upload/customer/'.$image_one_name;
              DB::table('customers')->where('id',$id)->update($data);
              $notification=array(
                 'messege'=>'Successfully Customer Updated',
                 'alert-type'=>'success'
                  );
                return Redirect()->back()->with($notification);  
          }  
        }
        else{
          $data['customer_image'] = $get_data->customer_image;
          DB::table('customers')->where('id',$id)->update($data);
           $notification=array(
                 'messege'=>'Successfully Customer Updated',
                 'alert-type'=>'success'
                  );
                return Redirect()->back()->with($notification);  
        }
    }

    public function DeleteCustomer($id)
    {
    	$delete=DB::table('customers')
                ->where('id',$id)
                ->first();
       $photo = $delete->customer_image;
       File::delete($photo);

       DB::table('customers')->where('id', $id)->delete();

                $notification=array(
                 'messege'=>'Successfully Customer Deleted',
                 'alert-type'=>'success'
                  );
                return Redirect()->back()->with($notification); 
    }
}
