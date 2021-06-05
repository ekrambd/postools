<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Image;
use File;
use App\Models\Model\Variant;
class ProductController extends Controller
{   
  public function __construct()
    {
        $this->middleware('auth_check');
    }
    public function AddProduct()
    {
    	return view('add_product');
    }

    public function InsertProduct(Request $request)
    {   
        $var_name = $request->var_name;
         $rand = rand(10,100);

      if($var_name == ''){
                 $data = array();
            $data['category_id'] = $request->category_id;
            $data['supplier_id'] = $request->supplier_id;
            $data['product_random_id'] = $rand;
            $data['product_name'] = $request->product_name;
            $data['product_barcode'] = $request->product_barcode;
            $data['product_price'] = $request->product_price;
            $data['product_unit'] = $request->product_unit;
            $data['stock_qty'] = $request->stock_qty;
            $data['stock_limit'] = $request->stock_limit;
                $image_one = $request->file('product_image');
            $image_one_name= hexdec(uniqid()).'.'.$image_one->getClientOriginalExtension();
                Image::make($image_one)->resize(270,270)->save('upload/product/'.$image_one_name);
                $data['product_image']='upload/product/'.$image_one_name;
             $product=DB::table('products')
                          ->insert($data);
                    $notification=array(
                     'messege'=>'Successfully Product Inserted ',
                     'alert-type'=>'success'
                    );
                return Redirect()->back()->with($notification); 
        }else{
             foreach($request->file('var_image') as $file)
            {
                $name = $file->getClientOriginalName();
                $file->move(public_path().'/upload/variant/', $name);  
                $imgData[] = 'upload/variant/'.$name;   
            }
        
        
            
        for($count=0; $count < count($var_name); $count++)
        {
           $data_var = array(
              'variant_id' =>$rand, 
              'product_name' => $request->product_name,
              'var_name' => $request->var_name[$count],
              'var_sku' => $request->var_sku[$count],
              'var_price' => $request->var_price[$count],
              'var_value' => $request->var_value[$count],
              'stock'     => $request->var_stock[$count],
              'var_image' => $imgData[$count],
           );
           $insert_data[] = $data_var;
            
        }
       
          DB::table('variants')->insert($insert_data);
          


           $products = array();
        $products['product_name'] = $request->product_name;

        $products['supplier_id'] = $request->supplier_id;
        $products['product_random_id'] = $rand;
        $products['category_id'] = $request->category_id;
        $products['product_price'] = $request->product_price;
        $products['product_random_id'] = $rand;
        $products['category_id'] = $request->category_id;
        $products['stock_qty'] = $request->stock_qty;
        $products['stock_limit'] = $request->stock_limit;
        $products['product_unit'] =  $request->product_unit;
        $products['product_barcode'] = $request->product_barcode;
        

        $image_one = $request->file('product_image');
            $image_one_name= hexdec(uniqid()).'.'.$image_one->getClientOriginalExtension();
                Image::make($image_one)->resize(270,270)->save('upload/product/'.$image_one_name);
                $products['product_image']='upload/product/'.$image_one_name;
        
        

        DB::table('products')->insert($products);

        
       
          $notification=array(
                 'messege'=>'Successfully Product Inserted',
                 'alert-type'=>'success'
                  );
                return Redirect()->back()->with($notification); 
        }
    }
    

    public function AllProduct()
    {
    	
      $all = DB::table('products')
         ->orderBy('id', 'DESC')
         ->get();
      
    	return view('all_product', compact('all'));
    }

    public function EditProduct($id)
    {
    	$edit = DB::table('products')->where('id',$id)->first();
    	return view('edit_product', compact('edit'));
    }

    public function DeleteProduct($id)
    {
    	$delete=DB::table('products')
                ->where('id',$id)
                ->first();
       $photo = $delete->product_image;
       File::delete($photo);

       DB::table('products')->where('id', $id)->delete();

                $notification=array(
                 'messege'=>'Successfully Product Deleted',
                 'alert-type'=>'success'
                  );
                return Redirect()->back()->with($notification); 
    }

    public function UpdateProduct(Request $request, $id)
    {   
        
    	$get_data = DB::table('products')->where('id', $id)->first();
      
       $products = array();
        $products['product_name'] = $request->product_name;

        $products['supplier_id'] = $request->supplier_id;
        $products['product_random_id'] = $get_data->product_random_id;
        $products['category_id'] = $request->category_id;
        $products['product_price'] = $request->product_price;
        $products['category_id'] = $request->category_id;
        $products['stock_qty'] = $request->stock_qty;
        $products['stock_limit'] = $request->stock_limit;
        $products['product_unit'] =  $request->product_unit;
        $products['product_barcode'] = $request->product_barcode;
        
      
        $image_one = $request->file('product_image');
        if($image_one){
           $image_one_name= hexdec(uniqid()).'.'.$image_one->getClientOriginalExtension();
                Image::make($image_one)->resize(270,270)->save('upload/product/'.$image_one_name);
                $products['product_image']='upload/product/'.$image_one_name;
              File::delete($get_data->product_image);
        }
        else{
          $products['product_image'] = $get_data->product_image;
        }
        
        DB::table('products')->where('id',$id)->update($products);   

      if($request->hints > 0){
          foreach($request->file('extra_var_image') as $file)
            {
                $name = $file->getClientOriginalName();
                $file->move(public_path().'/upload/variant/', $name);  
                $imgData[] = 'upload/variant/'.$name;   
            }
        
        $var_name = $request->extra_var_name;
            
        for($count=0; $count < count($var_name); $count++)
        {
           $data_var = array(
              'variant_id' =>$get_data->product_random_id, 
              'product_name' => $get_data->product_name,
              'var_name' => $request->extra_var_name[$count],
              'var_sku' => $request->extra_var_sku[$count],
              'var_price' => $request->extra_var_price[$count],
              'var_value' => $request->extra_var_value[$count],
              'stock'     => $request->extra_var_stock[$count],
              'var_image' => $imgData[$count],
           );
           $insert_data[] = $data_var;
            
        }
        DB::table('variants')->insert($insert_data);
        return back();     
      }else{
         
       if($request->var_name){
          foreach ($request->id as $item=>$v) {
          

            
            if(!empty($request->var_image[$item])){
                $id = $request->id[$item];
                
                $file = $request->file('var_image')[$item];
          
                 

                         $ext = $file->getClientOriginalExtension();
                         $name = rand(1000,100000).".".$ext;
                     
                      $file->move(public_path().'/upload/variant/', $name);  
                          

                       
                       $imgData = 'upload/variant/'.$name;
                        
                 

                   $for = DB::table('variants')   
                       ->where('id',$id)
                       ->where('var_image','!=',NULL)
                       ->get();
               foreach($for as $remove){
                  File::delete($remove->var_image);
               }
                
            }

            

            else{
                
               $imgData = $request->old_image[$item];
               
            }
            
            $datad=array(
             
              'var_image'=> $imgData,
              'variant_id' => $request->variant_id[$item],
              'var_name'=>$request->var_name[$item],
              'var_price'=>$request->var_price[$item],
              'stock'    => $request->stock[$item],
              'var_value'=>$request->var_value[$item],
              'var_sku'=>$request->var_sku[$item]
            );



             
     
          
             DB::table('variants')->where('id',$request->id[$item])->update($datad);
           
          }  
       }

        

          
         return back();

      }
      
       
       
      
    }

    public function RemoveImage($id)
    {
        $get_data = DB::table('variants')->where('id',$id)->first();
        DB::table('variants')
          ->where('id', $id)
          ->update(['var_image'=> NULL]);
      $file_path = $get_data->var_image;
            unlink($file_path);
      
    }

    public function Remove($id)
    {
      $get_data = DB::table('variants')->where('id',$id)->first();
      DB::table('variants')->where('id',$id)->delete();
       $file_path = $get_data->var_image;
       unlink($file_path);
    }
}
