<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class CategoryController extends Controller
{   

    public function __construct()
    {
        $this->middleware('auth_check');
    }

    public function AddCategory()
    {
    	return view('add_category');
    }

    public function InsertCategory(Request $request)
    {
    	$count = DB::table('categories')->where('category_name',$request->category_name)->count();
    	$data = array();
    	$data['category_name'] = $request->category_name;
        if($count > 0){
           $notification=array(
                     'messege'=>'Sorry, Already this category has been exist',
                     'alert-type'=>'error'
                    );
                return Redirect()->back()->with($notification);
        }else{
          DB::table('categories')->insert($data);
           $notification=array(
                     'messege'=>'Successfully Category Inserted ',
                     'alert-type'=>'success'
                    );
                return Redirect()->back()->with($notification);
        }
    }

    public function AllCategory()
    {
    	$all = DB::table('categories')->orderBy('id', 'DESC')->get();
    	return view('all_category', compact('all'));
    }

    public function EditCategory($id)
    {
    	$edit = DB::table('categories')->where('id',$id)->first();
    	return view('edit_category', compact('edit'));
    }

    public function UpdateCategory(Request $request,$id)
    {
    	 $get_data = DB::table('categories')->where('id', $id)->first();

        $count = DB::table('categories')->where('category_name', '!=', $get_data->category_name)->where('category_name', $request->category_name)->count();
        $data = array();
    	$data['category_name'] = $request->category_name;
        if($count > 0){
        	 $notification=array(
                     'messege'=>'Sorry, Already this category has been exist',
                     'alert-type'=>'error'
                    );
                return Redirect()->back()->with($notification);
        }
        else{
        	DB::table('categories')->where('id',$id)->update($data);
           $notification=array(
                     'messege'=>'Successfully Category Updated ',
                     'alert-type'=>'success'
                    );
                return Redirect()->back()->with($notification);
        }

    }

    public function DelereCategory($id)
    {
    	DB::table('categories')->where('id',$id)->delete();
    	$notification=array(
                     'messege'=>'Successfully Category Deleted ',
                     'alert-type'=>'success'
                    );
                return Redirect()->back()->with($notification);
    }
}
