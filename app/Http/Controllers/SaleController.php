<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
session_start();
use URL;
class SaleController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth_check');
    }
    public function SaleProduct()
    {
    	return view('sale_product');
    }

    public function ScanProduct($scan)
    {
        $data = DB::table('products')
         
          ->where('products.product_name','LIKE', "%{$scan}%")
          ->get();
       ?>
       <style>
         .pro_name:hover{
            background: green;
            cursor: pointer;
            padding: 10px;
            color: white;
         }
       </style>
     
        <?php
         foreach($data as $row):
        ?>
 
         <div>
         <p class="pro_name" data-id="<?php echo $row->id; ?>"><?php echo $row->product_name; ?></p><br>
        <?php endforeach; ?>
        </div>
       
       <?php
    }

    public function ScanSaleBarcode($scan)
    {   
      $cart_session_id = Session::get('cart_session_id');
       if(empty($cart_session_id)){
        $cart_session_id = rand(100,10000);
         Session::put('cart_session_id',$cart_session_id);
       }
        $product = DB::table('products')->where('product_barcode',$scan)->first();
        $scan_product = DB::table('products')
            ->where('product_barcode',$scan)
            ->first();
        $scan_variant = DB::table('variants')
             ->where('var_sku',$scan)
             ->first();
        if($scan_product){
           

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

          
        }else{
           $vdata = array();
           $vdata['cart_variant_id'] = $scan_variant->id;
           $vdata['cart_pro_name'] = $scan_variant->product_name;
           $vdata['cart_session_id'] = $cart_session_id;
           $vdata['qty'] = 1;
           $vdata['cart_pro_price'] = $scan_variant->var_price;
           $vdata['amount'] = $scan_variant->var_price * 1;
             $check = DB::table('carts')
             ->where('cart_variant_id',$scan_variant->id)
             ->where('cart_session_id',$cart_session_id)
             ->first();
             if($check){
                 DB::table('carts')
                 ->where('cart_variant_id',$scan_variant->id)
                 ->where('cart_session_id',$cart_session_id)
                 ->update(['qty' => $check->qty+1]);
              $find = DB::table("carts")->where('cart_variant_id',$scan_variant->id)->where('cart_session_id',$cart_session_id)->first();
              DB::table('carts')
                 ->where('cart_session_id',$cart_session_id)
                 ->where('cart_variant_id', $scan_variant->id)
                 ->update([
                    'amount' => $find->cart_pro_price * $find->qty,
                 ]);
             }else{
               DB::table('carts')->insert($vdata);
             }

             
            
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
                  <th>
                    <?php if($row->cart_variant_id == NULL): ?>
                     <?php echo $row->cart_pro_name; ?>
                    
                    <?php else: ?>
                     <?php echo $row->cart_pro_name; ?> (
                        <?php
                         $variant = DB::table('variants')
                            ->where('variants.id',$row->cart_variant_id)
                            ->first();
                          echo $variant->var_name.":"." ".$variant->var_value;
                        ?>
                     )
                    <?php endif; ?>
                    </th>
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
