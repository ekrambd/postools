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
                    <div class="panel-heading"><h3 class="panel-title">Update Product</h3></div>
                    <div class="panel-body">
                        <form role="form" action="{{URL::to('/update-product/'.$edit->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                       
                         <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="product_name">Product Name</label>
                              <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Product Name" value="{{$edit->product_name}}">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <label for="category_id">Select Category</label>
                            <select class="form-control" name="category_id" id="category">
                              <option selected="" disabled="">Choose Category</option>
                              @php
                               $categories = DB::table('categories')
                                  ->orderBy('id', 'DESC')
                                  ->get();
                              @endphp
                              @foreach($categories as $row)
                                <option value="{{$row->id}}" <?php if($row->id == $edit->category_id){
                                	echo "selected";
                                } ?>>{{$row->category_name}}</option>
                              @endforeach
                            </select>
                           </div>


                           <div class="col-md-3">
                            <label for="supplier_id">Select Supplier</label>
                            <select class="form-control" name="supplier_id" id="supplier">
                              <option selected="" disabled="">Choose Supplier</option>
                              @php
                               $suppliers = DB::table('suppliers')
                                  ->orderBy('id', 'DESC')
                                  ->get();
                              @endphp
                              @foreach($suppliers as $row)
                                <option value="{{$row->id}}" <?php if($edit->supplier_id==$row->id){echo "selected";} ?>>{{$row->supplier_name}}</option>
                              @endforeach
                            </select>
                           </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="product_price">Product Price ($)</label>
                              <input type="number" name="product_price" id="product_price" class="form-control" placeholder="Product Price" value="{{$edit->product_price}}">
                            </div>
                          </div>

                         </div>

                        

                         <div class="row">
                          <div class="col-md-3">
                            <label for="stock_qty">Stock Quantity</label>
                            <input type="number" name="stock_qty" id="stock_qty" class="form-control" placeholder="Stock Quantity" value="{{$edit->stock_qty}}">
                           </div>

                           <div class="col-md-3">
                            <label for="stock_limit">Stock Limit</label>
                            <input type="number" name="stock_limit" id="stock_limit" class="form-control" placeholder="Stock Limit" value="{{$edit->stock_limit}}">
                           </div>
                   
                           <div class="col-md-3">
                            <label for="product_unit">Product Unit</label>
                            <input type="text" name="product_unit" id="product_unit" class="form-control" placeholder="Product Unit" value="{{$edit->product_unit}}">
                           </div>

                           <div class="col-md-3">
                            <label for="product_barcode">Product Barcode</label>
                            <input type="number" name="product_barcode" id="product_barcode" class="form-control" placeholder="Product Barcode" value="{{$edit->product_barcode}}">
                            <a style="cursor: pointer; color: white;" class="btn btn-primary btn-sm" id="barcode_generator">Auto Barcode Generate</a>
                           </div>
                         </div> 

                        

                         <div class="row">
                          <div class="col-md-6">
                            <label for="product_image">Product Image</label>
                            <input type="file" name="product_image" class="form-control"  accept="image/*"   onchange="readURL(this);">
                          </div>
                          <div class="col-md-6">
                            <img id="image" style="width: 100px; height: 100px;" src="{{URL::to($edit->product_image)}}">
                           </div>
                         </div>
                    @php
                        $variants = DB::table('variants')
                           ->where('variant_id',$edit->product_random_id)
                           ->get();
                        $variant_count = DB::table('variants')
                           ->where('variant_id',$edit->product_random_id)
                           ->count();

                       @endphp
                       @if($variant_count > 0)
                        
                         <a style="cursor: pointer;" id="add_more" class="btn btn-primary btn-sm">Add More</a>
                    

                      <table class="table" style="margin-top: 30px;">
                       <thead>
                        <tr>
                          <th>Variant Name</th> 
                          <th>Variant Code (Sku)</th>
                          <th>Variant Value</th>
                          <th>Variant Price</th>
                          <th>Stock Quantity</th>
                          <th>Image</th>
                          <th></th>
                        </tr>
                       </thead>

                       <tbody>
                      @foreach($variants as $row)

                         <input type="hidden" name="id[]" value="{{$row->id}}">

                         <input type="hidden" name="variant_id[]" value="{{$row->variant_id}}">
                        <tr id="{{$row->id}}">
                         <td>
                           <input style="width: 80px;" type="text" name="var_name[]" class="form-control" value="{{$row->var_name}}">
                         </td>
                         <td>
                           <input style="width: 90px;" type="text" name="var_sku[]" class="form-control" value="{{$row->var_sku}}">
                         </td>
                         <td>
                            <input style="width: 70px;" type="text" name="var_value[]" class="form-control" value="{{$row->var_value}}">
                         </td>
                         <td>
                           <input style="width: 70px;" type="number" name="var_price[]" class="form-control" value="{{$row->var_price}}">
                         </td>
                         <td>
                          <input style="width: 70px;" type="number" name="stock[]" class="form-control" value="{{$row->stock}}"> 
                         </td>
                         <td>
                           <input type="file" id="var_image" name="var_image[]" data-id="{{$row->id}}">
                           <input type="hidden" name="old_image[]" value="{{$row->var_image}}">
                           @if($row->var_image !== NULL)
                          <img style="width: 40px; height: 40px;" src="{{URL::to($row->var_image)}}" class="source_image" id="source_image_{{$row->id}}" data-id="{{$row->id}}">
                          <a style="cursor: pointer;" class="btn btn-primary btn-sm remove_image" data-id="{{$row->id}}" id="source_remove_{{$row->id}}"><i class="fa fa-trash"></i></a>
                          @else
                          @endif
                         </td>
                         <td>
                          <button type="button" class="btn btn-danger btn-sm remove" data-id="{{$row->id}}">X</button>
                         </td>
                        </tr>
                        @endforeach 
                        
                       </tbody>
                      </table> 

                      @else
                      <input type="checkbox" id="variant" value="1">
                      <label for="variant" style="cursor: pointer;">Add Variant</label><br><br>
                      
                      <div class="more">

                       </div>

                       <table class="table">
                         <thead id="theader">

                         </thead>

                         <tbody id="tcontet">

                         </tbody>
                       </table>
                      
                      @endif
                      

                         <button type="submit" class="btn btn-success waves-effect waves-light btn-lg" id="submit">Update</button>
                        </form>
                    </div><!-- panel-body -->
                </div> <!-- panel -->

            </div> <!-- col-->




        </div>

      </div>
   </div>
 </div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
 
 <script type="text/javascript">
  $(document).ready(function(){
     $('#variant').click(function() {
    if($(this).is(':checked')){
        Theader();
        Tbody();
        more();
    }else{
      $("#theader").html("");
      $("#tcontet").html("");
      $(".more").html("");
    }
   });
   
   function Theader()
   {
      var tr = 

         '<tr>'+
         '<th>Variant Name</th>'+
         
         '<th>Variant Code (SKU)</th>'+
           '<th>Variant Value</th>'+
         '<th>Variant Price</th>'+
         '<th>Stock Quantity</th>'+
         '<th>Image</th>'+
        

         '<th></th>'+

         
       '</tr>';

       

       $('#theader').html(tr);
   }

   function Tbody()
   {
      var tr = 

         '<tr>'+
         '<td><input style="width: 80px;" type="text" name="extra_var_name[]" id="extra_var_name" class="form-control" placeholder="Variant Name"><input type="hidden" name="hints" class="hints" value="0"></td>'+
         
         '<td><input style="width: 90px;" type="text" name="extra_var_sku[]" class="form-control" placeholder="Variant Number (SKU)"></td>'+
        
        '<td><input style="width: 70px;" type="text" name="extra_var_value[]" class="form-control" placeholder="Variant Value"></td>'+

         '<td><input style="width: 70px;" type="number" name="extra_var_price[]" class="form-control" placeholder="Variant Price"></td>'+

         '<td><input style="width: 90px;" type="number" name="extra_var_stock[]" class="form-control" placeholder="Stock Quantity"></td>'+

         '<td><input type="file" name="extra_var_image[]"></td>'+
        

         '<td><a style="cursor: pointer;" class="btn btn-danger btn-sm remove">X</a></td>'+

         
       '</tr>';

       

       $('#tcontet').html(tr);
   }

    function more(){
      var span = '<span>'+'<button style="float: right;" type="button" id="var_more" class="btn btn-info btn-sm add_more">Add More</button>'+'</span>';
      $(".more").html(span);
    }
    

  


  });

  $(document).on("input", "#extra_var_name", function(){
      var input = $("#extra_var_name").val();
      if(input){
         $(".hints").val(1);
      }
  });
  $("#add_more").click(function(e){
     e.preventDefault();
      var tr = 

         '<tr>'+

         '<td><input style="width: 80px;" type="text" name="extra_var_name[]" id="extra_var_name" class="form-control" placeholder="Variant Name"><input type="hidden" name="hints" class="hints" value="0"></td>'+
         
         '<td><input style="width: 90px;" type="text" name="extra_var_sku[]" class="form-control" placeholder="Variant Number (SKU)"></td>'+
          
          '<td><input style="width: 70px;" type="text" name="extra_var_value[]" class="form-control" placeholder="Variant Value"></td>'+


         '<td><input style="width: 70px;" type="number" name="extra_var_price[]" class="form-control" placeholder="Variant Price"></td>'+

         '<td><input style="width: 90px;" type="number" name="extra_var_stock[]" class="form-control" placeholder="Stock Quantity"></td>'+

         '<td><input type="file" class="var_image" name="extra_var_image[]"></td>'
          
         +
        

         '<td><a style="cursor: pointer;" class="btn btn-danger btn-sm remove">X</a></td>'+

         
       '</tr>';

       

       $('tbody').append(tr);

       
  });




  $(document).on("click", "#var_more", function(e){
      e.preventDefault();
      var tr = 

         '<tr>'+
         '<td><input style="width: 80px;" type="text" name="extra_var_name[]" id="extra_var_name" class="form-control" placeholder="Variant Name"><input type="hidden" name="hints" class="hints" value="0"></td>'+
         
         '<td><input style="width: 90px;" type="text" name="extra_var_sku[]" class="form-control" placeholder="Variant Number (SKU)"></td>'+
          
          '<td><input style="width: 70px;" type="text" name="extra_var_value[]" class="form-control" placeholder="Variant Value"></td>'+


         '<td><input style="width: 70px;" type="number" name="extra_var_price[]" class="form-control" placeholder="Variant Price"></td>'+

         '<td><input style="width: 90px;" type="number" name="extra_var_stock[]" class="form-control" placeholder="Stock Quantity"></td>'+

         '<td><input type="file" name="extra_var_image[]"></td>'+
        

         '<td><a style="cursor: pointer;" class="btn btn-danger btn-sm remove">X</a></td>'+

         
       '</tr>';

       

       $('#tcontet').append(tr);
   });


 
  
  
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
 


  
</script>




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

   
</script>

<script>
 $(document).ready(function(){
       $(document).on("click", "#barcode_generator", function(e){
       e.preventDefault();
      var number  = Math.floor(200000 + Math.random() * 1000000);
      $("#product_barcode").val(number);
    });
  
 $(document).on("click", ".remove_image", function(e){
    e.preventDefault();
    var id = $(this).data("id");
    $("#source_image_"+id).remove();
    $("#source_remove_"+id).remove();
    $.ajax({
           url: "{{  url('/remove-image/') }}/"+id,
           type:"GET",
           dataType:"html",
           success:function(data) {
             //$("#sub_category").html(data);
             //$("#"+id).remove();
              
         
             console.log(data);
           },
                    
        }); 
 });


 });



 $(document).on("click", ".remove", function(e){
       e.preventDefault();
       
         $(this).parent().parent().remove();
       
        var id = $(this).data("id");
        $("#"+id).remove();
        $.ajax({
           url: "{{  url('/remove/') }}/"+id,
           type:"GET",
           dataType:"html",
           success:function(data) {
             //$("#sub_category").html(data);
             //$("#"+id).remove();
              
         
             console.log(data);
           },
                    
        }); 
              
    });


 $(function(){

       

      
         
        $('input[type="file"]').change(function(e){
            var photo = $(this)[0].files[0];
            var id = $(this).data('id');
           
       
             var imageUrl = window.URL.createObjectURL(photo);
             $("#source_image_"+id).attr('src', imageUrl);
             $(".show_off").css("display", "block");
        })
  })


</script>

 
@endsection