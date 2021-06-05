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
                    <div class="panel-heading"><h3 class="panel-title">Update Customer</h3></div>
                    <div class="panel-body">
                        <form role="form" action="{{URL::to('/update-customer/'.$edit->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group">
                                <label for="cusomer_name">Customer Name</label>
                                <input type="text" class="form-control" id="cusomer_name" placeholder="Customer Name" name="customer_name" value="{{$edit->customer_name}}">
                            </div>

                            <div class="form-group">
                                <label for="customer_email">Customer Email</label>
                                <input type="email" class="form-control" id="customer_email" placeholder="Customer Name" name="customer_email" value="{{$edit->customer_email}}">
                            </div>

                            <div class="form-group">
                                <label for="customer_phone">Customer Phone</label>
                                <input type="number" class="form-control" id="customer_phone"  placeholder="Customer Phone" name="customer_phone" value="{{$edit->customer_phone}}">
                            </div>

                            <div class="form-group">
                                <label for="customer_address">Customer Address</label>
                                <textarea rows="5" class="form-control" name="customer_address" id="customer_address" placeholder="Customer Address">{{$edit->customer_address}}</textarea>
                            </div>


                           <div class="row">
                          <div class="col-md-6">
                            <label for="customer_image">Image</label>
                            <input type="file" name="customer_image" class="form-control"  accept="image/*"   onchange="readURL(this);">
                          </div>
                          <div class="col-md-6">
                            <img id="image" style="width: 100px; height: 100px;" src="{{URL::to($edit->customer_image)}}">
                           </div>
                         </div>

                            
                            
                            
                            <button type="submit" class="btn btn-success waves-effect waves-light">Update</button>
                        </form>
                    </div><!-- panel-body -->
                </div> <!-- panel -->
            </div> <!-- col-->


      <p class="result"></p>

        </div>

      </div>
   </div>
 </div>

 <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
 
 <script type="text/javascript">

	function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              $('#image')
                  .attr('src', e.target.result)
                  .width(80)
                  .height(80);
          };
          reader.readAsDataURL(input.files[0]);
      }
   }

   // function forSearchBarcode()
   // {
   // 	   var val = $("#customer_phone").val();

   // 	   $.ajax({
   //           url: "{{  url('/test/') }}/"+val, 

   //           type:"GET",
   //           dataType:"html",
   //           success:function(data) {
                   
   //           	 console.log(data);
   //           	 $("#customer_phone").val("");
   //           	 $(".result").html(data);
   //                //$(".cart_total").html(data);
                
                
                
                
   //           },
                    
   //      });
   // }

  
</script>
 
@endsection