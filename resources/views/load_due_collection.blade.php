@extends('master')
@section('content')
 <div class="content-page">
   <div class="content">
      <div class="container">
       
       <div class="row">
	        <div class="col-sm-12">
	            <h4 class="pull-left page-title">Due Collection</h4>
	            <ol class="breadcrumb pull-right">
	                <li><a href="#">Moltran</a></li>
	                <li><a href="#">Forms</a></li>
	                <li class="active">General elements</li>
	            </ol>
	        </div>
        </div>
        

        <div class="row">
         

          <!-- Basic example -->
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="panel-title">Due Collection</h3></div>
                    <div class="panel-body">
                        <form role="form" action="{{URL::to('/load-collect_due/'.$order->id)}}" method="post">
                        @csrf
                          


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



                            
                            
                            
                            <button type="submit" class="btn btn-purple waves-effect waves-light">Submit</button>
                        </form>
                    </div><!-- panel-body -->
                </div> <!-- panel -->
            </div> <!-- col-->




        </div>

      </div>
   </div>
 </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    $(document).ready(function(){
    	$(document).on("input", "#paid", function(){
     var paid = parseInt($("#paid").val());
     if($("#paid").val() == ""){
        $("#due").val("");
     }else{
      var total = parseInt($(".order_total").val());
       var result = total - paid;
       $("#due").val(result);
     }
     
  });
    });
  </script>
 
@endsection