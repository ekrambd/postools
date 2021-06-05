@extends('master')
@section('content')
 <div class="content-page">
   <div class="content">
      <div class="container">
       
       <div class="row">
	        <div class="col-sm-12">
	            <h4 class="pull-left page-title">General elements</h4>
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
                    <div class="panel-heading"><h3 class="panel-title">Customer Due Report</h3></div>
                    <div class="panel-body">
                      
                            <div class="form-group">
                                <label for="name">Select Customer</label>
                                <select class="form-control autosearch" name="customer_id" id="customer_id">
                                 <option value="" selected="" disabled="">Select Customer</option>
                                 @php
                                  $customers = DB::table('customers')
                                     ->orderBy('id', 'DESC')
                                     ->get();
                                 @endphp
                                 @foreach($customers as $row)
                                  <option value="{{$row->id}}">{{$row->customer_name}}</option>
                                 @endforeach
                                </select>
                            </div>



                            
                            
                            
                            <button type="button" class="btn btn-purple waves-effect waves-light due">Submit</button>
                        
                    </div><!-- panel-body -->
                </div> <!-- panel -->
            </div> <!-- col-->
            
            <div class="due_report">
               
            </div>



        </div>

      </div>
   </div>
 </div>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
 <script>


   $('.autosearch').select2({
        placeholder: 'Select Customer',
        
    });

   $(document).ready(function(){
   	$(document).on("click", ".due", function(e){
   		e.preventDefault();
   	    var id = $(".autosearch").val();

   	    $.ajax({
             url: "{{  url('/customer-due-report/') }}/"+id,

             type:"GET",
             dataType:"html",
             success:function(data) {

                  $(".due_report").html(data);
                  
                console.log(data);
                
                
                
             },
                    
        });
   	});

   	$(document).on("click", ".due_collection", function(e){
   		e.preventDefault();
   		var id = $(this).data("id");
   		$.ajax({
             url: "{{  url('/due-collection/') }}/"+id,

             type:"GET",
             dataType:"html",
             success:function(data) {

                  $(".due_report").html(data);
                  
                console.log(data);
                
                
                
             },
                    
        });
   	});

   	$(document).on("click", ".due_collect", function(e){
   	   e.preventDefault();
   	    var id = $(this).data('id');
   	    var order_total = $(".order_total").val();
   	    var order_pay = $(".order_pay").val();
   	    var order_due = $(".order_due").val();
        $.ajax({
             url: "{{  url('/collect-due/') }}/"+id,

             type:"GET",
             data:{order_total:order_total, order_pay:order_pay, order_due:order_due},
             dataType:"html",
             success:function(data) {
             	 $(".due_report").html(data);
                 console.log(data);
                
                
                
             },
                    
        });
   	});
    

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