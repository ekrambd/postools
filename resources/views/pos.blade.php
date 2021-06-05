@extends('master')
@section('content')

 
 

  
    

<style>
  .all{
    background: green;
  }
 .btn-primary.active.focus, .btn-primary.active:focus, .btn-primary.active:hover, .btn-primary:active.focus, .btn-primary:active:focus, .btn-primary:active:hover, .open>.dropdown-toggle.btn-primary.focus, .open>.dropdown-toggle.btn-primary:focus, .open>.dropdown-toggle.btn-primary:hover{
    background-color: green;
 }
</style>
 <div class="content-page">
   <div class="content">
      <div class="container">
       
       <div class="row">
	        <div class="col-sm-12">
	            <h4 class="pull-left page-title">General elements</h4>
	            <ol class="breadcrumb pull-right">
	                <li><a href="#">Moltran</a></li>
	                <li><a href="#">Forms</a></li>
	                
	            </ol>
	        </div>
        </div>
        

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12 bg-info">
                <h4 class="pull-left page-title text-white">POS (Point of Sale) </h4>
                <ol class="breadcrumb pull-right">
                    <li><a href="#" class="text-white">Echovel</a></li>
                    <li class="text-white">{{ date('d F Y') }}</li>
                </ol>
            </div>
        </div><br>

        <div class="row">
         <div class="col-lg-6">
          <div id="myDIV" style="padding-bottom: 10px;">
          <button type="button" class="btn btn-primary all">All</button>
          @php
           $categories = DB::table('categories')->orderBy('id', 'DESC')->get();
          @endphp
          @foreach($categories as $row)
          <button type="button" class="btn btn-primary category" data-id="{{$row->id}}" id="source_cat_{{$row->id}}">{{$row->category_name}}</button>
          @endforeach
          </div>
          <div class="row">
          <div class="col-md-12">
          <div class="form-group">
            <label for="scan">Scan Barcode Or Search Product</label>
            <input type="text" class="form-control" id="scan" placeholder="Scan Barcode Or Search Product" name="scan" required autofocus="">
          </div>

          <div id="products">

          </div>
         </div>
          
        
         </div>
         	
          <div class="products_section">
            @php
           $products = DB::table('products')
             ->orderBy('products.id','DESC')
             ->get();
          @endphp
         	@foreach($products as $product)
            <button class="btn btn-sm cart_add"  data-id="{{$product->id}}">
                <div class="card" style="width: 13rem; height: 180px;">
                  <img src="{{URL::to($product->product_image)}}" class="card-img-top" style="height: 100px; width: 100px;">
                  <div class="card-body">
                    <h5 class="card-title">{{$product->product_name}}</h5>
                    <p>${{$product->product_price}}</p>
                    @if($product->stock_limit >= $product->stock_qty)
                    <p style="background: red; padding: 10px; color: white;">Sold Out</p>
                    @else
                    <p>{{$product->stock_qty}} {{$product->product_unit}} are available</p>
                    @endif
                  </div>
                </div>
             </button>
             @endforeach
            </div>
         </div>

         <div class="col-lg-6">
           <div class="card-body">
                       <table class="table table-sm table-striped">
                        <thead>
                          <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Unit</th>
                            <th scope="col">Total</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody class="cart_data">

                          @php
                           $cart_session_id = Session::get('cart_session_id');
                           $carts = DB::table('carts')
                             ->where('carts.cart_session_id',$cart_session_id)
                             ->orderBy('id', 'DESC')
                             ->get();
                          @endphp
                          @foreach($carts as $row)
                          <tr id="<?php echo $row->id; ?>">
                            <th>{{$row->cart_pro_name}}</th>
                            <td>
                             <a style="cursor: pointer;" class="btn btn-success increment" data-id="{{$row->id}}">+</a>
                              <input type="number" class="qty" style="width: 50px;" id="source_cart_{{$row->id}}" value="{{$row->qty}}" readonly="">

                              <a style="cursor: pointer;" class="btn btn-danger decrement" data-id="{{$row->id}}">-</a>
                             

                            </td>
                            <td>$<span class="cart_price" id="source_price_{{$row->id}}">{{$row->cart_pro_price}}</span></td>
                            <td>$<span class="amount" id="source_amount_{{$row->id}}">{{$row->amount}}</span></td>
                            <td><a  class="btn btn-sm btn-danger remove" data-id="{{$row->id}}">x</a></td>
                          </tr>
                         @endforeach
                        </tbody>
                      </table>
                      <hr>
                    </div>
                    
                    <div class="card-footer">
                      <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                         Total Quantity:
                          <strong><span class="cart_count"></span></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                         Sub Total:
                          <strong>$<span class="sub_total"></span></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          Vat:
                         <strong> 5% </strong>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          <b>Discount:
                         <input type="text" class="form-control" id="discount" placeholder="Discount">
                        </li>

                         <li class="list-group-item d-flex justify-content-between align-items-center total_area">
                          Total:
                         <strong> $<span class="total" id="total"></span></strong>
                        </li>
                      </ul>
                      <br>
                    <form action="{{URL::to('/store-order')}}" method="post" target="__blank"> 
                      @csrf
                      <label>Customer Name</label>
                      <select class="form-control" name="customer_id">
                        @php
                         $customers = DB::table('customers')
                            ->orderBy('id', 'DESC')
                            ->get();
                        @endphp
                        @foreach($customers as $row)
                         <option value="{{$row->id}}">{{$row->customer_name}}</option>
                        @endforeach
                      </select>
                      <input type="hidden" name="total" class="total_price" value="">

                      <input type="hidden" name="sub_total" class="sub_total_price" value="">

                      <input type="hidden" name="discount" class="discount_price" value="">
                      
                      <input type="hidden" name="paid_amount" id="paid_amount" value="">

                      <input type="hidden" name="due_amount" id="due_amount" value="">

                      <label for="paid">Pay</label>
                      <input type="number" id="paid" name="pay" class="form-control">

                      <label>Due</label>
                      <input type="text" id="due" name="due" class="form-control" readonly="">

                      <label>Pay By </label>
                      <select class="form-control payby" name="payby">
                         <option value="HandCash">Hand Cash</option>
                         <option value="Cheaque">Cheaque</option>
                         <option value="GiftCard">Gift Card</option>
                      </select>

                      <br>
                      <button type="submit" id="submit" class="btn btn-success">Save & Print</button>
                    </form>
                  </div>
         </div>
        </div>


        </div>

      </div>
   </div>
 </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
 $(document).ready(function(){
  sub_total();
  quantity();
  total();
   $(document).on("click", ".cart_add", function(e){
      e.preventDefault();
      var id = $(this).data("id");
      var qty = $(".qty").val();
       $.ajax({
             url: "{{  url('/add-to-cart/') }}/"+id+"/"+qty,

             type:"GET",
             dataType:"html",
             success:function(data) {

                   $(".cart_data").html(data);
                   
                   sub_total();
                   quantity();
                   total();
                      const Toast = Swal.mixin({
                        toast: true, 
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                      })

                   Toast.fire({
                      type: 'success',
                      title: 'Successfully, Product Added to cart'
                    })
                  
                
                
                
                
             },
                    
        });

   });

   $(document).on("input", "#paid", function(){
     var paid = parseInt($("#paid").val());
     if($("#paid").val() == ""){
        $("#due").val("");
     }else{
      var total = parseInt($(".total").html());
       var result = total - paid;
       $("#due").val(result);
     }
     
  });
  


  $(document).on("input", "#discount", function(){

       var discount = $(this).val();
      
        var sum = parseInt($(".sub_total").html());
        var parse = parseInt(sum*5/100+sum);
        
      
      $.ajax({
             url: "{{  url('/discount') }}",

             type:"GET",
             data:{discount:discount},
             dataType:"html",
             success:function(data) {
                 if(discount == ""){
             
                  $(".total").html(parse);
                  
                 }else{
                  $(".total").html(data);
                   //console.log(data);
                 }
                 
             },
                    
        });
   });
  
   
   
 });

 


 $('tbody').delegate('.increment', 'click', function(){
     
      var tr = $(this).parent().parent();
       
      var id = $(this).data("id");
      
      var qty = $("#source_cart_"+id).val();
       var inc = qty++;
       $("#source_cart_"+id).val(qty); 
     
      var price = $("#source_price_"+id).html();
   
      var result = price * qty;
      $("#source_amount_"+id).html(result);
      sub_total();
      quantity();
      total();
      $.ajax({
             url: "{{  url('/increment/') }}/"+id+"/"+qty,

             type:"GET",
             dataType:"html",
             success:function(data) {
                 
                 
                  
                 console.log(data);
                
                
                
             },
                    
        });
   });


  $('tbody').delegate('.decrement', 'click', function(e){
      e.preventDefault();
      var tr = $(this).parent().parent();
       
      var id = $(this).data("id");
      
      var qty = $("#source_cart_"+id).val();
       var inc = qty--;
       $("#source_cart_"+id).val(qty); 
     
      var price = $("#source_price_"+id).html();
   
      var result = price * qty;
      $("#source_amount_"+id).html(result);
        sub_total();
        quantity();
        total();
      $.ajax({
             url: "{{  url('/decrement/') }}/"+id+"/"+qty,

             type:"GET",
             dataType:"html",
             success:function(data) {
                 
               console.log(data);
                
                
                
             },
                    
        });
   });

  $(document).on("click", ".remove", function(e){
    e.preventDefault();
    var id = $(this).data("id");
    $("#"+id).remove();
     
     $.ajax({
             url: "{{  url('/cart-remove/') }}/"+id,

             type:"GET",
             dataType:"html",
             success:function(data) {
                 
                 
                  
                sub_total();
                
                quantity();
                total();
                
             },
                    
        });



  });




  function sub_total(){
         
           var sum = 0;
             $('.amount').each(function(){

         
                sum += parseFloat($(this).html());
             

             });
            $(".sub_total").html(sum);
            //calculate_grand_total();
        }
   

 // function forSearchBarcode()
 // {
 //    var val = $("#scan").val();
 //        $.ajax({
 //             url: "{{  url('/scan-barcode/') }}/"+val,  

 //             type:"GET",
 //             dataType:"html",
 //             success:function(data) {
                   
 //                console.log(data);
 //                $("#scan").val("");
 //                 $(".cart_data").html(data);
 //                  //$(".cart_total").html(data);
              
 //                quantity();
 //                total();
 //                sub_total();
 //                console.log(val);
                
 //             },
                    
 //        });
 // } 

 $(document).keypress("#scan",function(event){
            if (event.which == '10' || event.which == '13') {
                event.preventDefault();
            }
        });
 
 var delay = (function() {
            var timer = 0;
            return function(callback, ms) {
                clearTimeout (timer);
                timer = setTimeout(callback, ms);
            };
        })();

 $("#scan").on("input", function(e){
      e.preventDefault();
       var scan = $("#scan").val();
        var check = $.isNumeric(scan);  
        if(scan == ''){
          $('#products').fadeOut(); 
         
        }
        else if(check){
           delay(function() { searchProduct(scan); }, 200);
        }
        else{
          $.ajax({
                 url: "{{  url('/scan-product/') }}/"+scan,
                 type:"GET",
                 dataType:"html",
                 success:function(data) {

                    $('#products').fadeIn();
                    $("#products").html(data);
                    console.log(data);
                    

                 },
                    
            });
        }
    });

 function searchProduct(scan)
 {
     $.ajax({ 
             url: "{{  url('/scan-sale_barcode/') }}/"+scan,  

             type:"GET",
             dataType:"html",
             success:function(data) {
                   
                console.log(data);
                $("#scan").val("");
                 $(".cart_data").html(data);
                  //$(".cart_total").html(data);
              
                quantity();
                total();
                sub_total();
                
                
             },
                    
        });
 }

 function quantity()
 {  
  var sum = 0;
             $('.qty').each(function(){

         
                sum += parseFloat($(this).val());
             

             });
    
    $(".cart_count").html(sum);
    
 }

 function total()
 {
    var sum = 0;
             $('.amount').each(function(){

         
                sum += parseFloat($(this).html());
             

             });
    var total = parseInt(sum*5/100+sum);
    
    $(".total").html(total);
 }



$(document).on("click", ".category", function(e){
   e.preventDefault();
   var id = $(this).data("id");
  
     $("#source_cat_"+id).addClass("active").siblings().removeClass("active");  
    $(".all").css("background", "#1e88e5");


    $.ajax({
             url: "{{  url('/category-details/') }}/"+id,

             type:"GET",
             dataType:"html",
             success:function(data) {
                $(".products_section").html(data);
                
             },
                    
        });

});

$(document).on("click", ".all", function(e){
   e.preventDefault();
    $(".all").css("background", "green");
   

   $.ajax({
             url: "{{  url('/products') }}",

             type:"GET",
             dataType:"html",
             success:function(data) {
                $(".products_section").html(data);
                
             },
                    
        });

});


$(document).on("click",".pro_name", function(e){
       e.preventDefault();
       var id = $(this).data("id");
       $.ajax({
             url: "{{  url('/add-to-cart/') }}/"+id,

             type:"GET",
             dataType:"html",
             success:function(data) {

                   $(".cart_data").html(data);
                   
                   sub_total();
                   quantity();
                   total();
                      const Toast = Swal.mixin({
                        toast: true, 
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                      })

                   Toast.fire({
                      type: 'success',
                      title: 'Successfully, Product Added to cart'
                    })
                  
                
                
                
                
             },
                    
        });
    });


$(document).on("change", "#products", function(){
    var id = $("#products").val();
    $.ajax({
             url: "{{  url('/add-to-cart/') }}/"+id,

             type:"GET",
             dataType:"html",
             success:function(data) {

                   $(".cart_data").html(data);
                   
                   sub_total();
                   quantity();
                   total();
                      const Toast = Swal.mixin({
                        toast: true, 
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                      })

                   Toast.fire({
                      type: 'success',
                      title: 'Successfully, Product Added to cart'
                    })
                  
                
                
                
                
             },
                    
        });
});


    $('.autosearch').select2({
        placeholder: 'Choose Product',
        
    });


  $(document).on("click", "#submit", function(){
     var sub_total = $(".sub_total").html();
     var total = $(".total").html();
     var discount = $("#discount").val();
     var paid = $("#paid").val();
     var due = $("#due").val();
     $("#paid_amount").val(paid);
     $("#due_amount").val(due);
     $(".sub_total_price").val(sub_total);
     $(".total_price").val(total);
     $(".discount_price").val(discount);
     
     $(".cart_data").html("");
     $(".total").html("0");
     $("#discount").val("");
     $(".cart_count").html("0");
     $(".sub_total").html("0");
     $("#paid").val("");
     $("#due").val("");
     
  });

  
</script>
 
@endsection