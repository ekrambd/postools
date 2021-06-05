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
                    <div class="panel-heading"><h3 class="panel-title">Daily Due Report</h3></div>
                    <div class="panel-body">
                        
                        <div class="row">
                          <div class="col-md-6">
                          	 <div class="form-group">
                                <label for="start_date">Start Date</label>
                               <input style="width: 300px;" type="date" class="form-control start_date" id="start_date">
                            </div>
                           </div>
                            

                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="end_date">End Date</label>
                               <input style="width: 300px;" type="date" class="form-control end_date" id="end_date">
                            </div>
                            </div>
                            

                          </div>  
                            
                            
                            <button type="button" class="btn btn-purple waves-effect waves-light daily_click">Submit</button>
                        </form>
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
  <script>
    $(document).ready(function(){
    	$(document).on("click", ".daily_click", function(e){
    		e.preventDefault();
    		var start_date = $(".start_date").val();
    		var end_date = $(".end_date").val();
    		 $.ajax({
	             url: "{{  url('/daily-due_collection') }}",

	             type:"GET",
	             data:{start_date:start_date, end_date:end_date},
	             dataType:"html",
	             success:function(data) {
	             	$(".due_report").html(data);
	                
	                
	                
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
   	    var start_date = $(".start_date").val();
   	    var end_date = $(".end_date").val();
        $.ajax({
             url: "{{  url('/daily-collect-due/') }}/"+id,

             type:"GET",
             data:{order_total:order_total, order_pay:order_pay, order_due:order_due,start_date:start_date,end_date:end_date},
             dataType:"html",
             success:function(data) {
             	 $(".due_report").html(data);
             
                
                
                
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