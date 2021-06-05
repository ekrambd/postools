<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class ReturnController extends Controller
{   
  public function __construct()
    {
        $this->middleware('auth_check');
    }
    public function ReturnSales($id)
    {   
    	$order = DB::table('orders')
          ->join('customers', 'orders.customer_id', 'customers.id')
          ->select('customers.customer_name', 'customers.customer_email', 'customers.customer_phone','customers.customer_address', 'orders.*')
          ->where('orders.id',$id)
          ->first();
        $carts = DB::table('carts')
           ->join('products', 'carts.cart_pro_name', 'products.product_name')
           ->select('products.product_unit', 'carts.*')
           ->where('carts.cart_session_id',$order->order_session_id)
           ->get();
        return view('sales_return', compact('order','carts'));
    	
    }

    public function ReturnValue(Request $request, $id)
    {
        $order = DB::table('orders')->where('id',$id)->first();
        $return_total = $request->return_total;
        $return_qty = $request->return_qty;
        foreach ($request->id as $item=>$v){
          
       
          DB::table('carts')->where('id',$request->id[$item])->update([
               'return_qty'=> $return_qty[$item],
               'return_amount'=> $request->return_amount[$item],
              
          ]);
        }


        DB::table('orders')->where('order_session_id',$order->order_session_id)->update([
             'order_return_total' => $return_total,
             'return_pay' => $request->return_pay,
              'return_due' => $request->return_due,
          ]);

        return back(); 
    }
}
