<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use URL;
class ReportController extends Controller
{   
  public function __construct()
    {
        $this->middleware('auth_check');
    }
    public function CustomerDue()
    {
    	return view('customer_due');
    }

    public function CustomerDueReport($id)
    {
    	
    	$count = DB::table('orders')
    	    ->where('customer_id',$id)
    	    ->where('orders.order_status', 1)
    	    ->where('due', '>', 0)
    	    ->count();

    	if($count > 0){
    		$due = DB::table('orders')
    		 
    		  ->where('orders.customer_id',$id)
    	      ->where('orders.due', '>', 0)
    	      ->where('orders.order_status', 1)
    	      ->get();
             
           $total = DB::table('orders')
    	       ->where('customer_id',$id)
    	       ->where('orders.order_status', 1)
    	      ->where('due', '>', 0)
    	      ->sum('due');
    	   $customer = DB::table('customers')
    	         ->where('id',$id)
    	         ->first();

    	  ?>
    	  <h3>Due Report For: <?php echo $customer->customer_name; ?></h3>
           <table class="table">
            <thead>
             <tr>
              <th>SL</th>
              
              <th>Order Date</th>
              <th>Order Total</th>
              <th>Pay</th>
              <th>Due</th>
              <th>Action</th>
             </tr>	
            </thead> 
            <tbody>
             <?php
               foreach($due as $key=>$row):
              ?>
              <tr>
              	<td><?php echo $key+1; ?></td>
         
              	<td><?php echo $row->order_date; ?></td>
              	<td>$<?php echo $row->order_total; ?></td>
              	<td>$<?php echo $row->pay; ?></td>
              	<td>$<?php echo $row->due; ?></td>
              	<td>
              	 <a style="cursor: pointer;" class="btn btn-primary btn-sm due_collection" data-id="<?php echo $row->id; ?>">Due Collection</a>	
              	</td>
              </tr>
          <?php endforeach; ?>
            </tbody>
            
           </table>
           <strong>Total Due: $<?php echo $total; ?></strong>
    	  <?php
    	}else{
    		echo "no_due";
    	}
    }

    public function DueCollection($id)
    {
    	$order = DB::table('orders')->where('id',$id)->first();
    	?>
         <div class="form-group">
           <label for="total">Total Due</label>
           <input type="text" name="total" id="total" class="form-control order_total" value="<?php echo $order->due; ?>" readonly="">
         </div>

         <div class="form-group">
           <label for="paid">Pay</label>
           <input type="text" name="pay" id="paid" class="form-control order_pay" placeholder="Paid Amount">
         </div>

         <div class="form-group">
           <label for="due">Due</label>
           <input type="text" name="due" id="due" class="form-control order_due" placeholder="Due Amount" readonly="">
         </div>  

         <button type="button" class="btn btn-success due_collect" data-id="<?php echo $order->id; ?>">Submit</button>
    	<?php
    }

    public function CollectDue(Request $request, $id)
    {  
    	$order = DB::table('orders')->where('id',$id)->first();
        DB::table('orders')
           ->where('id',$id)
           ->update([
           	  'pay' => $order->pay+$request->order_pay,
           	  'due' => $request->order_due,
           ]);

       

        $due = DB::table('orders')
    		 
    		  ->where('orders.customer_id',$order->customer_id)
    		  ->where('orders.order_status', 1)
    	      ->where('orders.due', '>', 0)
    	      ->get();
             
           $total = DB::table('orders')
    	       ->where('customer_id',$order->customer_id)
    	       ->where('orders.order_status', 1)
    	      ->where('due', '>', 0)
    	      ->sum('due');

    	   $customer = DB::table('customers')
    	         ->where('id',$order->customer_id)
    	         ->first();

    	  ?>
    	  <h3>Due Report For: <?php echo $customer->customer_name; ?></h3>
           <table class="table">
            <thead>
             <tr>
              <th>SL</th>
              
              <th>Order Date</th>
              <th>Order Total</th>
              <th>Pay</th>
              <th>Due</th>
              <th>Action</th>
             </tr>	
            </thead> 
            <tbody>
             <?php
               foreach($due as $key=>$row):
              ?>
              <tr>
              	<td><?php echo $key+1; ?></td>
         
              	<td><?php echo $row->order_date; ?></td>
              	<td>$<?php echo $row->order_total; ?></td>
              	<td>$<?php echo $row->pay; ?></td>
              	<td>$<?php echo $row->due; ?></td>
              	<td>
              	 <a style="cursor: pointer;" class="btn btn-primary btn-sm due_collection" data-id="<?php echo $row->id; ?>">Due Collection</a>	
              	</td>
              </tr>
          <?php endforeach; ?>
            </tbody>
            
           </table>
           <strong>Total Due: $<?php echo $total; ?></strong>
    	  <?php



    }

    public function TodayDue()
    {
    	$today = date('Y-m-d');
    	$today_due = DB::table('orders')
    	    ->join('customers', 'orders.customer_id', 'customers.id')
    	    ->select('customers.customer_name', 'orders.*')
    	    ->where('orders.order_date',$today)
    	    ->where('orders.order_status', 1)
    	    ->orderBy('orders.id', 'DESC')
    	    ->get();
        $total = DB::table('orders')
             ->where('order_date',$today)
             ->sum('due');
        return view('today_due', compact('today_due', 'total'));  
    }

    public function LoadDueCollection($id)
    {
    	$order = DB::table('orders')
    	    ->where('id',$id)
    	    ->first();
    	return view('load_due_collection', compact('order'));
    }

    public function LoadCollectDue(Request $request, $id)
    {
        $order = DB::table('orders')->where('id',$id)->first();
        DB::table('orders')
           ->where('id',$id)
           ->update([
           	  'pay' => $order->pay+$request->pay,
           	  'due' => $request->due,
           ]);

         $notification=array(
                     'messege'=>'Successfully Due Collected ',
                     'alert-type'=>'success'
                    );   
       return redirect('/today-due')->with($notification);
    }

    public function DailyDue()
    {
    	return view('daily_due_report');
    }

    public function DailyDueCollection(Request $request)
    {
    	$data = DB::table('orders')
    	   ->join('customers', 'orders.customer_id', 'customers.id')
    	   ->select('customers.customer_name', 'orders.*')
    	   ->where('orders.order_date', '>=', $request->start_date)
    	   ->where('orders.order_date', '<=', $request->end_date)
    	   ->where('orders.due', '>', 0)
    	   ->where('orders.order_status', 1)
    	   ->get();

    	 $total = DB::table('orders')
    	   ->where('orders.order_date', '>=', $request->start_date)
    	   ->where('orders.order_date', '<=', $request->end_date)
    	   ->where('orders.order_status', 1)
    	   ->sum('due'); 
    	?>
         
         <table class="table">
         	<thead>
         	  <tr>
         	   <th>SL</th>
         	   <th>Customer Name</th>
         	   <th>Order Date</th>
         	   <th>Order Total</th>
         	   <th>Pay</th>
         	   <th>Due</th>
         	   <th>Action</th>
         	  </tr>	
         	</thead>
         	<tbody>
         	<?php
             foreach($data as $key=>$row):
         	?>
              <tr>
               <td><?php echo $key+1; ?></td>
                <td><?php echo $row->customer_name; ?></td>
	            <td><?php echo $row->order_date; ?></td>
	            <td>$<?php echo $row->order_total; ?></td>
	            <td>$<?php echo $row->pay; ?></td>
	            <td>$<?php echo $row->due; ?></td>
	            <td>
	             <a style="cursor: pointer;" class="btn btn-primary due_collection" data-id="<?php echo $row->id; ?>">Due Collection</a>	
	            </td>
	            
              </tr>
            <?php endforeach; ?>
         	</tbody>
         </table>
          <b>Total Due: $<?php echo $total; ?></b> 
    	<?php
    }

    public function DailyCollectDue(Request $request,$id)
    {
    	$start_date = $request->start_date;
    	$end_date = $request->end_date;
        
        $order = DB::table('orders')->where('id',$id)->first();
        DB::table('orders')
           ->where('id',$id)
           ->update([
           	  'pay' => $order->pay+$request->order_pay,
           	  'due' => $request->order_due,
           ]);

    	$data = DB::table('orders')
    	   ->join('customers', 'orders.customer_id', 'customers.id')
    	   ->select('customers.customer_name', 'orders.*')
    	   ->where('orders.order_date', '>=', $start_date)
    	   ->where('orders.order_date', '<=', $end_date)
    	   ->where('orders.order_status', 1)
    	   ->where('orders.due', '>', 0)
    	   ->get();
    	 $total = DB::table('orders')
    	   ->where('orders.order_date', '>=', $start_date)
    	   ->where('orders.order_date', '<=', $end_date)
    	   ->sum('due'); 
         

         ?>
         
         <table class="table">
         	<thead>
         	  <tr>
         	   <th>SL</th>
         	   <th>Customer Name</th>
         	   <th>Order Date</th>
         	   <th>Order Total</th>
         	   <th>Pay</th>
         	   <th>Due</th>
         	   <th>Action</th>
         	  </tr>	
         	</thead>
         	<tbody>
         	<?php
             foreach($data as $key=>$row):
         	?>
              <tr>
               <td><?php echo $key+1; ?></td>
                <td><?php echo $row->customer_name; ?></td>
	            <td><?php echo $row->order_date; ?></td>
	            <td>$<?php echo $row->order_total; ?></td>
	            <td>$<?php echo $row->pay; ?></td>
	            <td>$<?php echo $row->due; ?></td>
	            <td>
	             <a style="cursor: pointer;" class="btn btn-primary due_collection" data-id="<?php echo $row->id; ?>">Due Collection</a>	
	            </td>
	            
              </tr>
            <?php endforeach; ?>
         	</tbody>
         </table>
          <b>Total Due: $<?php echo $total; ?></b> 
    	<?php



    }

    public function MonthlyDue()
    {
        return view('monthly_due');
    }

    public function MonthlyDueReport(Request $request)
    {   
    	$count = DB::table('orders')
    	    ->where('orders.order_month', $request->select_month)
    	   ->where('orders.order_year', $request->select_year)
    	   ->where('orders.order_status', 1)
    	   ->where('orders.due', '>', 0)
    	   ->count();
    	if($count > 0){
    		$data = DB::table('orders')
    	   ->join('customers', 'orders.customer_id', 'customers.id')
    	   ->select('customers.customer_name', 'orders.*')
    	   ->where('orders.order_month', $request->select_month)
    	   ->where('orders.order_year', $request->select_year)
    	   ->where('orders.order_status', 1)
    	   ->where('orders.due', '>', 0)
    	   ->get();
    	$total = DB::table('orders')
    	   ->where('orders.order_month', $request->select_month)
    	   ->where('orders.order_year', $request->select_year)

    	   ->sum('due'); 
         

         ?>
         
         <table class="table">
         	<thead>
         	  <tr>
         	   <th>SL</th>
         	   <th>Customer Name</th>
         	   <th>Order Date</th>
         	   <th>Order Total</th>
         	   <th>Pay</th>
         	   <th>Due</th>
         	   <th>Action</th>
         	  </tr>	
         	</thead>
         	<tbody>
         	<?php
             foreach($data as $key=>$row):
         	?>
              <tr>
               <td><?php echo $key+1; ?></td>
                <td><?php echo $row->customer_name; ?></td>
	            <td><?php echo $row->order_date; ?></td>
	            <td>$<?php echo $row->order_total; ?></td>
	            <td>$<?php echo $row->pay; ?></td>
	            <td>$<?php echo $row->due; ?></td>
	            <td>
	             <a style="cursor: pointer;" class="btn btn-primary due_collection" data-id="<?php echo $row->id; ?>">Due Collection</a>	 
	            </td>
	            
              </tr>
            <?php endforeach; ?>
         	</tbody>
         </table>
          <b>Total Due: $<?php echo $total; ?></b> 
    	<?php 
    	}else{
    		echo "no_record";
    	}
    	
    }

    public function MonthlyDueCollection($id)
    {
    	$order = DB::table('orders')->where('id',$id)->first();
    	?>
         <div class="form-group">
           <label for="total">Total Due</label>
           <input type="text" name="total" id="total" class="form-control order_total" value="<?php echo $order->due; ?>" readonly="">
         </div>

         <div class="form-group">
           <label for="paid">Pay</label>
           <input type="text" name="pay" id="paid" class="form-control order_pay" placeholder="Paid Amount">
         </div>

         <div class="form-group">
           <label for="due">Due</label>
           <input type="text" name="due" id="due" class="form-control order_due" placeholder="Due Amount" readonly="">
         </div>  

         <button type="button" class="btn btn-success due_collect" data-id="<?php echo $order->id; ?>">Submit</button>
    	<?php
    }

    public function MonthlyCollectDue(Request $request,$id)
    {
    	$order = DB::table('orders')->where('id',$id)->first();
        DB::table('orders')
           ->where('id',$id)
           ->update([
           	  'pay' => $order->pay+$request->order_pay,
           	  'due' => $request->order_due,
           ]);

        

         $data = DB::table('orders')
    	   ->join('customers', 'orders.customer_id', 'customers.id')
    	   ->select('customers.customer_name', 'orders.*')
    	   ->where('orders.order_month', $request->select_month)
    	   ->where('orders.order_year', $request->select_year)
    	   ->where('orders.order_status', 1)
    	   ->where('orders.due', '>', 0)
    	   ->get();
    	$total = DB::table('orders')
    	   ->where('orders.order_month', $request->select_month)
    	   ->where('orders.order_year', $request->select_year)

    	   ->sum('due');      
        ?>
         <table class="table">
          <thead>
          	<tr>
          	<th>SL</th>
            <th>Customer Name</th>
            <th>Order Date</th>
            <th>Order Total</th>
            <th>Pay</th>
            <th>Due</th>
            <th>Action</th>
           </tr>
          </thead>
          <tbody>
           <?php
            foreach($data as $key=>$row):
           ?>
            <tr>
              <td><?php $key+1; ?></td> 
              <td><?php echo $row->customer_name; ?></td>
              <td><?php echo $row->order_date; ?></td>	
              <td>$<?php echo $row->order_total; ?></td>
              <td>$<?php echo $row->pay; ?></td>
              <td>$<?php echo $row->due; ?></td>
              <td>
	             <a style="cursor: pointer;" class="btn btn-primary due_collection" data-id="<?php echo $row->id; ?>">Due Collection</a>	 
	            </td>
            </tr>
           <?php endforeach; ?>
          </tbody>
         </table>
        <?php   
    }

    public function YearlyDue()
    {
    	return view('yearly_due');
    }

    public function YearlyDueReport(Request $request)
    {
    	$count = DB::table('orders')
    	   
    	   ->where('orders.order_year', $request->select_year)
    	   ->where('orders.order_status', 1)
    	   ->where('orders.due', '>', 0)
    	   ->count();
    	if($count > 0){
    		$data = DB::table('orders')
    	   ->join('customers', 'orders.customer_id', 'customers.id')
    	   ->select('customers.customer_name', 'orders.*')
    	 
    	   ->where('orders.order_year', $request->select_year)
    	   ->where('orders.order_status', 1)
    	   ->where('orders.due', '>', 0)
    	   ->get();
    	$total = DB::table('orders')
    
    	   ->where('orders.order_year', $request->select_year)

    	   ->sum('due'); 
         

         ?>
         
         <table class="table">
         	<thead>
         	  <tr>
         	   <th>SL</th>
         	   <th>Customer Name</th>
         	   <th>Order Date</th>
         	   <th>Order Total</th>
         	   <th>Pay</th>
         	   <th>Due</th>
         	   <th>Action</th>
         	  </tr>	
         	</thead>
         	<tbody>
         	<?php
             foreach($data as $key=>$row):
         	?>
              <tr>
               <td><?php echo $key+1; ?></td>
                <td><?php echo $row->customer_name; ?></td>
	            <td><?php echo $row->order_date; ?></td>
	            <td>$<?php echo $row->order_total; ?></td>
	            <td>$<?php echo $row->pay; ?></td>
	            <td>$<?php echo $row->due; ?></td>
	            <td>
	             <a style="cursor: pointer;" class="btn btn-primary due_collection" data-id="<?php echo $row->id; ?>">Due Collection</a>	 
	            </td>
	            
              </tr>
            <?php endforeach; ?>
         	</tbody>
         </table>
          <b>Total Due: $<?php echo $total; ?></b> 
    	<?php 
    	}else{
    		echo "no_record";
    	}

    }

    public function YearlyCollectDue(Request $request,$id)
    {
    	$order = DB::table('orders')->where('id',$id)->first();
        DB::table('orders')
           ->where('id',$id)
           ->update([
           	  'pay' => $order->pay+$request->order_pay,
           	  'due' => $request->order_due,
           ]);

        

         $data = DB::table('orders')
    	   ->join('customers', 'orders.customer_id', 'customers.id')
    	   ->select('customers.customer_name', 'orders.*')
    	   
    	   ->where('orders.order_year', $request->select_year)
    	   ->where('orders.due', '>', 0)
    	   ->get();
    	$total = DB::table('orders')
    	  
    	   ->where('orders.order_year', $request->select_year)

    	   ->sum('due');      
        ?>
         <table class="table">
          <thead>
          	<tr>
          	<th>SL</th>
            <th>Customer Name</th>
            <th>Order Date</th>
            <th>Order Total</th>
            <th>Pay</th>
            <th>Due</th>
            <th>Action</th>
           </tr>
          </thead>
          <tbody>
           <?php
            foreach($data as $key=>$row):
           ?>
            <tr>
              <td><?php $key+1; ?></td> 
              <td><?php echo $row->customer_name; ?></td>
              <td><?php echo $row->order_date; ?></td>	
              <td>$<?php echo $row->order_total; ?></td>
              <td>$<?php echo $row->pay; ?></td>
              <td>$<?php echo $row->due; ?></td>
              <td>
	             <a style="cursor: pointer;" class="btn btn-primary due_collection" data-id="<?php echo $row->id; ?>">Due Collection</a>	 
	            </td>
            </tr>
           <?php endforeach; ?>
          </tbody>
         </table>
        <?php  
    }

    public function TodaySales()
    {   
    	$date = date('Y-m-d');
    	$today = DB::table('orders')
    	    ->join('customers', 'orders.customer_id', 'customers.id')
    	    ->select('customers.customer_name', 'orders.*')
    	    ->where('orders.order_date',$date)
    	    ->where('orders.order_status', 1)
    	    ->orderBy('orders.id', 'DESC')
            ->get();
       $total = DB::table('orders')
    	    ->where('order_date',$date)
    	    ->where('orders.order_status', 1)
    	    ->sum('order_total');
       return view('today_sales_report', compact('today', 'total'));
    }

    public function MonthlySales()
    {
    	return view('monthly_sales_report');
    }

    public function MonthlySalesReport(Request $request)
    {
        $count = DB::table('orders')
         ->where('orders.order_month', $request->select_month)
         ->where('orders.order_year', $request->select_year)
         ->where('orders.order_status', 1)
         ->where('orders.due', '>', 0)
         ->count();
      if($count > 0){
        $data = DB::table('orders')
         ->join('customers', 'orders.customer_id', 'customers.id')
         ->select('customers.customer_name', 'orders.*')
        ->where('orders.order_month', $request->select_month)
         ->where('orders.order_year', $request->select_year)
         ->where('orders.order_status', 1)
         
         ->get();
      $total = DB::table('orders')
        ->where('orders.order_month', $request->select_month)
         ->where('orders.order_year', $request->select_year)
         ->where('orders.order_status', 1)
         ->sum('order_total'); 
         

         ?>
         
         <table class="table">
          <thead>
            <tr>
             <th>SL</th>
             <th>Customer Name</th>
             <th>Order Date</th>
             <th>Order Total</th>
             <th>Pay</th>
             <th>Due</th>
             
            </tr> 
          </thead>
          <tbody>
          <?php
             foreach($data as $key=>$row):
          ?>
              <tr>
               <td><?php echo $key+1; ?></td>
                <td><?php echo $row->customer_name; ?></td>
              <td><?php echo $row->order_date; ?></td>
              <td>$<?php echo $row->order_total; ?></td>
              <td>$<?php echo $row->pay; ?></td>
              <?php
               if($row->due == 0):
              ?>
              <td>Full Paid</td>
              <?php else: ?>
              <td>$<?php echo $row->due; ?></td>
             <?php endif; ?>
              
              </tr>
            <?php endforeach; ?>
          </tbody>
         </table>
          <b>Total Sales Amount: $<?php echo $total; ?></b> 
          <p>N.B: Due amounts are not counted</p>
      <?php 
      }else{
        echo "no_record";
      }
    }

    public function DailySales()
    {
       return view('daily_sales_report');
    }

    public function DailySalesReport(Request $request)
    {
       $count = DB::table('orders')
         ->where('orders.order_date', '>=', $request->start_date)
         ->where('orders.order_date', '<=', $request->end_date)
         ->where('orders.order_status', 1)
     
         ->count();
      if($count > 0){
        $data = DB::table('orders')
         ->join('customers', 'orders.customer_id', 'customers.id')
         ->select('customers.customer_name', 'orders.*')
       ->where('orders.order_date', '>=', $request->start_date)
         ->where('orders.order_date', '<=', $request->end_date)
         ->where('orders.order_status', 1)
         
         ->get();
      $total = DB::table('orders')
        ->where('orders.order_date', '>=', $request->start_date)
         ->where('orders.order_date', '<=', $request->end_date)
         ->where('orders.order_status', 1)
         ->sum('order_total'); 
         

         ?>
         
         <table class="table">
          <thead>
            <tr>
             <th>SL</th>
             <th>Customer Name</th>
             <th>Order Date</th>
             <th>Order Total</th>
             <th>Pay</th>
             <th>Due</th>
             
            </tr> 
          </thead>
          <tbody>
          <?php
             foreach($data as $key=>$row):
          ?>
              <tr>
               <td><?php echo $key+1; ?></td>
                <td><?php echo $row->customer_name; ?></td>
              <td><?php echo $row->order_date; ?></td>
              <td>$<?php echo $row->order_total; ?></td>
              <td>$<?php echo $row->pay; ?></td>
              <?php
               if($row->due == 0):
              ?>
              <td>Full Paid</td>
              <?php else: ?>
              <td>$<?php echo $row->due; ?></td>
             <?php endif; ?>
              
              </tr>
            <?php endforeach; ?>
          </tbody>
         </table>
          <b>Total Sales Amount: $<?php echo $total; ?></b> 
          <p>N.B: Due amounts are not counted</p>
      <?php 
      }else{
        echo "no_record";
      }
    }

    public function YearlySales()
    {
        return view('yearly_sales_report');
    }

    public function YearlySalesReport(Request $request)
    {
        $count = DB::table('orders')
         
         ->where('orders.order_year', $request->select_year)
         ->where('orders.order_status', 1)
         
         ->count();
      if($count > 0){
        $data = DB::table('orders')
         ->join('customers', 'orders.customer_id', 'customers.id')
         ->select('customers.customer_name', 'orders.*')
       
         ->where('orders.order_year', $request->select_year)
         ->where('orders.order_status', 1)
      
         ->get();
      $total = DB::table('orders')
    
         ->where('orders.order_year', $request->select_year)

         ->sum('order_total'); 
         

         ?>
         
         <table class="table">
          <thead>
            <tr>
             <th>SL</th>
             <th>Customer Name</th>
             <th>Order Date</th>
             <th>Order Total</th>
             <th>Pay</th>
             <th>Due</th>
            
            </tr> 
          </thead>
          <tbody>
          <?php
             foreach($data as $key=>$row):
          ?>
              <tr>
               <td><?php echo $key+1; ?></td>
                <td><?php echo $row->customer_name; ?></td>
              <td><?php echo $row->order_date; ?></td>
              <td>$<?php echo $row->order_total; ?></td>
              <td>$<?php echo $row->pay; ?></td>
               <?php
               if($row->due == 0):
              ?>
              <td>Full Paid</td>
              <?php else: ?>
              <td>$<?php echo $row->due; ?></td>
             <?php endif; ?>
              
              
              </tr>
            <?php endforeach; ?>
          </tbody>
         </table>
          <b>Total Sales Amount: $<?php echo $total; ?></b> 
           <p>N.B: Due amounts are not counted</p>
      <?php 
      }else{
        echo "no_record";
      }
    }
}
