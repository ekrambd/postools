@extends('master')
@section('content')
 <div class="content-page">
   <div class="content">
      <div class="container">
       
       <div class="row">
	        <div class="col-sm-12">
	            <h4 class="pull-left page-title">Monthly Due Report</h4>
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
                    <div class="panel-heading"><h3 class="panel-title">Monthly Due</h3></div>
                    <div class="panel-body">
                      
                            <div class="form-group">
                              <label for="name">Select Month</label>
                              <select class="form-control select_month" name="select_month">
                              	<option value="January">January</option>
                              	<option value="February">February</option>
                              	<option value="March">March</option>
                              	<option value="April">April</option>
                              	<option value="May">May</option>
                              	<option value="June">June</option>
                              	<option value="July">July</option>
                              	<option value="August">August</option>
                              	<option value="	September">	September</option>
                              	<option value="October">October</option>
                              	<option value="November">November</option>
                              	<option value="December">December</option>
                              </select>	
                                
                            </div>


                            <div class="form-group">

                             <label>Select Year</label>

                             <select class="form-control select_year">
                             	<option value="2021">2021</option>
                             	<option value="2022">2022</option>
                             	<option value="2023">2023</option>
                             	<option value="2024">2024</option>
                             	<option value="2025">2025</option>
                             </select>	

                            </div>

                            
                            
                            
                            <button type="button" class="btn btn-purple waves-effect waves-light sales_month">Search</button>
                        </form>
                    </div><!-- panel-body -->
                </div> <!-- panel -->
            </div> <!-- col-->

         <div class="sales_report"></div>


        </div>

      </div>
   </div>
 </div>

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script>
   $(document).ready(function(){
   	  $(document).on("click", ".sales_month", function(e){
   	  	 e.preventDefault();
   	  	 var select_month = $(".select_month").val();
   	  	 var select_year = $(".select_year").val();
   	  	 $.ajax({
                url: "{{  url('/monthly-sales-report') }}",

               type:"GET",
              data:{select_month:select_month, select_year:select_year},
               dataType:"html",
               success:function(data) {

               	 if(data == 'no_record'){
               	 	const Toast = Swal.mixin({
                        toast: true, 
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                      })

                   Toast.fire({
                      type: 'error',
                      title: 'No records were found'
                    })
               	 }else{
               	 	 $(".sales_report").html(data);
               	 }

             	
                
                
                
                
             },
                    
          });
   	  });
   });
  </script>
 
@endsection