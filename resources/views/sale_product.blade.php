@extends('master')
@section('content')
 <div class="content-page">
   <div class="content">
      <div class="container">
       
       <div class="row">
	        <div class="col-sm-12">
	            <h4 class="pull-left page-title">Sale Your Product</h4>
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
                    <div class="panel-heading"><h3 class="panel-title">Sale Product</h3></div>
                    <div class="panel-body">
                        
                            <div class="form-group">
                                <label for="scan">Scan Barcode Or Search Product</label>
                                <input type="text" class="form-control" id="scan" placeholder="Scan Barcode Or Search Product" name="scan" required autofocus="">
                            </div>
                            
                            
                            <div id="products">

                            </div>

                            <table class="table">
                              <thead>
                                <tr>
                                  <th>Name</th>
                                  <th>Qty</th>
                                  <th>Unit</th>
                                  <th>Total</th>
                                  <th>Action</th>
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
                            @if($row->cart_variant_id == NULL)
                             <th>{{$row->cart_pro_name}}</th>
                            @else
                            <th>{{$row->cart_pro_name}} (
                               @php
                                 $variant = DB::table('variants')
                            ->where('variants.id',$row->cart_variant_id)
                            ->first();
                          echo $variant->var_name.":"." ".$variant->var_value;
                               @endphp
                            )</th>
                            @endif
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
  sub_total();
  quantity();
  total();

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

  function sub_total(){
         
           var sum = 0;
             $('.amount').each(function(){

         
                sum += parseFloat($(this).html());
             

             });
            $(".sub_total").html(sum);
            //calculate_grand_total();
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
</script>
 
 
@endsection