<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
session_start();
use URL;
class CartController extends Controller
{  

    public function __construct()
    {
        $this->middleware('auth_check');
    }
    public function AddCart($id,$qty)
    {
    	$cart_session_id = Session::get('cart_session_id');
    	if(empty($cart_session_id)){
    		$cart_session_id = rand(100,10000);
    		Session::put('cart_session_id',$cart_session_id);
    	}
    	$product = DB::table('products')->where('id',$id)->first();

    	$data = array();
    	$data['product_id'] = $id;
    	$data['cart_pro_name'] = $product->product_name;
    	$data['cart_pro_price'] = $product->product_price;
    	$data['cart_session_id'] = $cart_session_id;
    	$data['qty'] = 1;
    	$data['amount'] = $product->product_price * 1;
      
      if($product->stock_limit >= $qty){
           echo "sold_out";
      }else{
        $check = DB::table('carts')
           ->where('product_id',$id)
           ->where('cart_session_id',$cart_session_id)
           ->first();
        if($check){
          if($qty >= $check->product_limit){
             echo "out";
          }else{
            DB::table('carts')
             ->where('product_id',$id)
             ->where('cart_session_id',$cart_session_id)
             ->update(['qty' => $check->qty+1]);
          $find = DB::table("carts")->where('product_id',$id)->where('cart_session_id',$cart_session_id)->first();
          DB::table('carts')
             ->where('cart_session_id',$cart_session_id)
             ->where('product_id', $id)
             ->update([
                'amount' => $find->cart_pro_price * $find->qty,
             ]);
          }
          



        }else{
          DB::table('carts')->insert($data);
        }

       $carts = DB::table('carts')
             ->where('carts.cart_session_id',$cart_session_id)
             ->orderBy('id', 'DESC')
             ->get();
        ?>
        <?php 
        foreach($carts as $row):
        ?>
         <tr id="<?php echo $row->id; ?>"> 
            <th><?php echo $row->cart_pro_name; ?></th>
            <td>
                <a style="cursor: pointer;" class="btn btn-success increment" data-id="<?php echo $row->id; ?>">+</a>
                  <input type="number" class="qty" style="width: 50px;" id="source_cart_<?php echo $row->id; ?>" value="<?php echo $row->qty ?>" readonly>

                  <a style="cursor: pointer;" class="btn btn-danger decrement" data-id="<?php echo $row->id; ?>">-</a>

             

            </td>
            <td>$<span class="cart_price" id="source_price_<?php echo $row->id; ?>"><?php echo $row->cart_pro_price; ?></span></td>
                            <td>$<span class="amount" id="source_amount_<?php echo $row->id; ?>"><?php echo $row->amount; ?></span></td>
            <td><a  class="btn btn-sm btn-danger remove" data-id="<?php echo $row->id; ?>">x</a></td>
          </tr>
        <?php endforeach; ?>
        <?php
      }   	

       
        
    }

    public function ScanBarcode($val)
    {
        $cart_session_id = Session::get('cart_session_id');
        if(empty($cart_session_id)){
            $cart_session_id = rand(100,10000);
            Session::put('cart_session_id',$cart_session_id);
        }
        $product = DB::table('products')->where('product_barcode',$val)->first();

        $data = array();
        $data['product_id'] = $product->id;
        $data['cart_pro_name'] = $product->product_name;
        $data['cart_pro_price'] = $product->product_price;
        $data['cart_session_id'] = $cart_session_id;
        $data['qty'] = 1;
        $data['amount'] = $product->product_price * 1;
        
       $check = DB::table('carts')
           ->where('product_id',$product->id)
           ->where('cart_session_id',$cart_session_id)
           ->first();
        if($check){
            DB::table('carts')
               ->where('product_id',$product->id)
               ->where('cart_session_id',$cart_session_id)
               ->update(['qty' => $check->qty+1]);
          $find = DB::table("carts")->where('product_id',$product->id)->where('cart_session_id',$cart_session_id)->first();
          DB::table('carts')
             ->where('cart_session_id',$cart_session_id)
             ->where('product_id', $product->id)
             ->update([
                'amount' => $find->cart_pro_price * $find->qty,
             ]);



        }else{
            DB::table('carts')->insert($data);
        }

       $carts = DB::table('carts')
             ->where('carts.cart_session_id',$cart_session_id)
             ->orderBy('id', 'DESC')
             ->get();
        ?>
        <?php 
        foreach($carts as $row):
        ?>
         <tr id="<?php echo $row->id; ?>"> 
            <th><?php echo $row->cart_pro_name; ?></th>
            <td>
                <a style="cursor: pointer;" class="btn btn-success increment" data-id="<?php echo $row->id; ?>">+</a>
                  <input type="number" class="qty" style="width: 50px;" id="source_cart_<?php echo $row->id; ?>" value="<?php echo $row->qty ?>">

                  <a style="cursor: pointer;" class="btn btn-danger decrement" data-id="<?php echo $row->id; ?>">-</a>

             

            </td>
            <td>$<span class="cart_price" id="source_price_<?php echo $row->id; ?>"><?php echo $row->cart_pro_price; ?></span></td>
                            <td>$<span class="amount" id="source_amount_<?php echo $row->id; ?>"><?php echo $row->amount; ?></span></td>
            <td><a  class="btn btn-sm btn-danger remove" data-id="<?php echo $row->id; ?>">x</a></td>
          </tr>
      <?php endforeach; ?>
        <?php
    }

    public function CartRemove($id)
    {
        DB::table('carts')->where('id',$id)->delete();
        echo "deleted";
    }

  

    public function Discount(Request $request)
    {    
       $cart_session_id = Session::get('cart_session_id');
       $total = DB::table('carts')
           ->where('cart_session_id',$cart_session_id)
           ->sum('amount');
        $full_total = floor($total*5/100+$total);
         if(strpos($request->discount, '%') !== false){
               $convert_discount = str_replace("%", "",$request->discount);
              $final_total = $full_total*$convert_discount/100-$full_total;
              $convert_total = str_replace("-", "",$final_total);
             echo floor($convert_total);
          }else{
            echo $full_total - $request->discount;
          }
    }

    public function Increment($id,$qty)
    {
       $cart = DB::table('carts')->where('id',$id)->first();
      
       DB::table('carts')
           ->where('id',$cart->id)
           ->update(['qty' => $qty]);
       $final_cart = DB::table('carts')->where('id',$id)->first();
       DB::table('carts')
         ->where('id',$id)
         ->update(['amount' => $cart->cart_pro_price*$qty]);
       echo "updated";
    }

    public function Decrement($id,$qty)
    {
       $cart = DB::table('carts')->where('id',$id)->first();
      
       DB::table('carts')
           ->where('id',$cart->id)
           ->update(['qty' => $qty]);
       $final_cart = DB::table('carts')->where('id',$id)->first();
       DB::table('carts')
         ->where('id',$id)
         ->update(['amount' => $cart->cart_pro_price*$qty]);
       echo "updated";
    }

    public function CategoryDetails($id)
    {
      $products = DB::table('products')
          ->where('category_id', $id)
          ->orderBy('products.id','DESC')
          ->get();
        ?>
        <?php
         foreach($products as $product):
        ?>
         <button class="btn btn-sm cart_add"  data-id="<?php echo $product->id; ?>">
                <div class="card" style="width: 13rem; height: 180px;">
                  <img src="<?php echo URL::to($product->product_image); ?>" class="card-img-top" style="height: 100px; width: 100px;">
                  <div class="card-body">
                    <h5 class="card-title"><?php echo $product->product_name; ?></h5>
                    <p>$<?php echo $product->product_price;?></p>
                    <p><?php echo $product->stock_qty; ?>
                    <?php echo $product->product_unit; ?> are available</p>
                  </div>
                </div>
             </button>
        <?php endforeach; ?>
        <?php
    }

    public function Products()
    {
        $products = DB::table('products')
          
          ->orderBy('products.id','DESC')
          ->get();
        ?>
        <?php
         foreach($products as $product):
        ?>
         <button class="btn btn-sm cart_add"  data-id="<?php echo $product->id; ?>">
                <div class="card" style="width: 13rem; height: 180px;">
                  <img src="<?php echo URL::to($product->product_image); ?>" class="card-img-top" style="height: 100px; width: 100px;">
                  <div class="card-body">
                    <h5 class="card-title"><?php echo $product->product_name; ?></h5>
                    <p>$<?php echo $product->product_price;?></p>
                    <p><?php echo $product->stock_qty; ?>
                    <?php echo $product->product_unit; ?> are available</p>
                  </div>
                </div>
             </button>
        <?php endforeach; ?>
        <?php
    }

    public function CartDestory()
    {
       $cart_session_id = Session::get('cart_session_id');
       Session::forget('cart_session_id');
    }
}
