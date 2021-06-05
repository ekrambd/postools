<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
class OrderController extends Controller
{   
  public function __construct()
    {
        $this->middleware('auth_check');
    }
    public function StoreOrder(Request $request)
    {
    	$cart_session_id = Session::get('cart_session_id');
    	$cart = DB::table('carts')->where('cart_session_id',$cart_session_id)->first();
    	$data = array();
    	$data['product_id'] = $cart->product_id;
      $data['order_variant_id'] = $cart->cart_variant_id;
    	$data['order_session_id'] = $cart->cart_session_id;
    	$data['customer_id'] = $request->customer_id;
    	$data['order_total'] = $request->total;
    	$data['order_sub_total'] = $request->sub_total;
    	$data['discount'] = $request->discount;
        $data['order_date'] = date("Y-m-d");
        $data['order_month'] = date('F');
        $data['order_year'] = date('Y');
    	$data['amount'] = $cart->amount;
    	$data['pay'] = $request->paid_amount;
    	$data['due'] = $request->due_amount;
    	$data['payby'] = $request->payby;
    	
    	
    	DB::table('orders')->insert($data);
      $order = DB::table('orders')
          ->join('customers', 'orders.customer_id', 'customers.id')
          ->select('customers.customer_name', 'customers.customer_email', 'customers.customer_phone','customers.customer_address', 'orders.*')
          ->where('orders.order_session_id',$cart_session_id)
          ->first();
      $carts = DB::table('carts')
           ->join('products', 'carts.cart_pro_name', 'products.product_name')
           ->select('products.product_unit', 'carts.*')
           ->where('carts.cart_session_id',$order->order_session_id)
           ->get();
      Session::forget('cart_session_id');
      return view('print_page', compact('order', 'carts'));
    	 // $notification=array(
      //                'messege'=>'Successfully Order Done ',
      //                'alert-type'=>'success'
      //               );
      //           return Redirect()->back()->with($notification);
    }

    public function InvoiceList()
    {
        $all = DB::table('orders')
          ->join('customers', 'orders.customer_id', 'customers.id')
          ->select('customers.customer_name', 'orders.*')
          ->orderBy('orders.id', 'DESC')
          ->get();
        return view('invoice_list', compact('all'));
    }

    public function ViewInvoice($id)
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
        return view('view_invoice', compact('order','carts'));
    }

    public function ApproveOrder($order_session_id)
    {
       $carts = DB::table('carts')
          ->where('cart_session_id',$order_session_id)
          ->get();

       foreach($carts as $val){
           if($val->cart_variant_id == NULL){
              DB::table('products')
                ->where('id',$val->product_id)
                ->update(['stock_qty' => DB::raw('stock_qty -'.$val->qty)]);
           }else{
             DB::table('variants')
                ->where('id',$val->cart_variant_id)
                ->update(['stock' => DB::raw('stock -'.$val->qty)]);
           }
       }

       DB::table('orders')
          ->where('order_session_id',$order_session_id)
          ->update(['order_status' => 1]);

       $notification=array(
                     'messege'=>'Successfully Order Done ',
                     'alert-type'=>'success'
                    );
                return Redirect()->back()->with($notification);
    }

    public function CancelOrder($order_session_id)
    {
       $carts = DB::table('carts')
          ->where('cart_session_id',$order_session_id)
          ->get();

       foreach($carts as $val){
           if($val->cart_variant_id == NULL){
              DB::table('products')
                ->where('id',$val->product_id)
                ->update(['stock_qty' => DB::raw('stock_qty +'.$val->qty)]);
           }else{
             DB::table('variants')
                ->where('id',$val->cart_variant_id)
                ->update(['stock' => DB::raw('stock +'.$val->qty)]);
           }
       }

       DB::table('orders')
          ->where('order_session_id',$order_session_id)
          ->update(['order_status' => 0]);
      $notification=array(
                     'messege'=>'Successfully Order has been canceled ',
                     'alert-type'=>'success'
                    );
                return Redirect()->back()->with($notification);
    }
    
}
