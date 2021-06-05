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

            <div class="daily_sales">

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
             url: "{{  url('/daily-sales-report') }}",

             type:"GET",
             data:{start_date:start_date,end_date:end_date},
             dataType:"html",
             success:function(data) {
             	 $(".daily_sales").html(data);
             
                
                
                
             },
                    
        });
   	 });
   });
  </script>
 
@endsection