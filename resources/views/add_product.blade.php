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
                    <div class="panel-heading"><h3 class="panel-title">Add Product</h3></div>
                    <div class="panel-body">
                        <form role="form" action="{{URL::to('/insert-product')}}" method="post" enctype="multipart/form-data">
                        @csrf
                         <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="product_name">Product Name</label>
                              <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Product Name" required="">
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
                                <option value="{{$row->id}}">{{$row->category_name}}</option>
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
                                <option value="{{$row->id}}">{{$row->supplier_name}}</option>
                              @endforeach
                            </select>
                           </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="product_price">Product Price ($)</label>
                              <input type="number" name="product_price" id="product_price" class="form-control" placeholder="Product Price" required="">
                            </div>
                          </div>

                         </div>

                        

                         <div class="row">
                          <div class="col-md-3">
                            <label for="stock_qty">Stock Quantity</label>
                            <input type="number" name="stock_qty" id="stock_qty" class="form-control" placeholder="Stock Quantity" required="">
                           </div>

                           <div class="col-md-3">
                            <label for="stock_limit">Stock Limit</label>
                            <input type="number" name="stock_limit" id="stock_limit" class="form-control" placeholder="Stock Limit" required="">
                           </div>

                           <div class="col-md-3">
                            <label for="product_unit">Product Unit</label>
                            <input type="text" name="product_unit" id="product_unit" class="form-control" placeholder="Product Unit" required="">
                           </div>

                           <div class="col-md-3">
                            <label for="product_barcode">Product Barcode</label>
                            <input type="number" name="product_barcode" id="product_barcode" class="form-control" placeholder="Product Barcode" required="">
                            <a style="cursor: pointer; color: white;" class="btn btn-primary btn-sm" id="barcode_generator">Auto Barcode Generate</a>
                           </div>
                         </div> 

                        

                         <div class="row">
                          <div class="col-md-6">
                            <label for="product_image">Product Image</label>
                            <input type="file" name="product_image" class="form-control"  accept="image/*"  required onchange="readURL(this);">
                          </div>
                          <div class="col-md-6">
                            <img id="image" style="width: 100px; height: 100px;" src="">
                           </div>
                         </div>


                      
                        <div class="form-group">
                        <input id="variant" type="checkbox" class="check">
                        <label for="variant" style="cursor: pointer;">Add Variant</label>
                      </div>

                       <div class="more">

                       </div>

                       <table class="table">
                         <thead id="theader">

                         </thead>

                         <tbody id="tcontet">

                         </tbody>
                       </table>

                         <button type="submit" class="btn btn-purple waves-effect waves-light btn-lg">Submit</button>
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
      //$("#sample").show();
    }else{
      $("#theader").html("");
      $("#tcontet").html("");
      $(".more").html("");
    }
  });
  

  $(document).on("click", ".add_more", function(){
        var tr = 

         '<tr>'+
         '<td><input style="width: 90px;" type="text" name="var_name[]" class="form-control" placeholder="Variant Name"></td>'+
         
         '<td><input style="width: 90px;" type="number" name="var_sku[]" class="form-control" placeholder="Variant Number (SKU)"></td>'+
          
          '<td><input style="width: 90px;" type="text" name="var_value[]" class="form-control" placeholder="Variant Value"></td>'+


         '<td><input style="width: 90px;" type="number" name="var_price[]" class="form-control" placeholder="Variant Price"></td>'+

         '<td><input style="width: 90px;" type="number" name="var_stock[]" class="form-control" placeholder="Stock Quantity"></td>'+

         '<td><input type="file" name="var_image[]"></td>'+
        

         '<td><a style="cursor: pointer;" class="btn btn-danger btn-sm remove">X</a></td>'+

         
       '</tr>';

       

       $('tbody').append(tr);
    });
    

    $(document).on("click", ".remove", function(e){
       e.preventDefault();
       
      
         $(this).parent().parent().remove();
        
      
    });

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
         '<td><input style="width: 90px;" type="text" name="var_name[]" class="form-control" placeholder="Variant Name"></td>'+ 
         
         '<td><input style="width: 90px;" type="text" name="var_sku[]" class="form-control" placeholder="Variant Number (SKU)"></td>'+
        
        '<td><input style="width: 90px;" type="text" name="var_value[]" class="form-control" placeholder="Variant Value"></td>'+

         '<td><input style="width: 90px;" type="number" name="var_price[]" class="form-control" placeholder="Variant Price"></td>'+

         '<td><input style="width: 90px;" type="number" name="var_stock[]" class="form-control" placeholder="Stock Quantity"></td>'+

         '<td><input type="file" name="var_image[]"></td>'+
        

         '<td><a style="cursor: pointer;" class="btn btn-danger btn-sm remove">X</a></td>'+

         
       '</tr>';

       

       $('#tcontet').html(tr);
   }

    function more(){
      var span = '<span>'+'<button style="float: right;" type="button" class="btn btn-info btn-sm add_more">Add More</button>'+'</span>';
      $(".more").html(span);
    }
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

<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>


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

 });
</script>

 
@endsection