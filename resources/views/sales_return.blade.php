@extends('master')
@section('content')
  <div class="content-page">
    <div class="content">
      <div class="container">
         <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="pull-left page-title">Invoice</h4>
                <ol class="breadcrumb pull-right">
                    <li><a href="#">Moltran</a></li>
                    <li><a href="#">Pages</a></li>
                    <li class="active">Invoice</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" id="printableArea">
                <div class="panel panel-default">
                    <!-- <div class="panel-heading">
                        <h4>Invoice</h4>
                    </div> -->
                    <div class="panel-body">
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-right"><img src="{{asset('images/logo_dark.png')}}" alt="velonic"></h4>
                                
                            </div>
                            <div class="pull-right">
                                <h4>Invoice # <br>
                                    <strong>{{$order->order_year}}-{{date('d')}}-{{$order->order_session_id}}</strong>
                                </h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                
                                <div class="pull-left m-t-30">
                                    <address>
                                      <strong>Cusomer Name: {{$order->customer_name}}</strong><br>
                                      Address: {{$order->customer_address}}<br>
                                      <abbr title="Phone">Phone:</abbr> {{$order->customer_phone}}
                                      </address> 
                                </div>
                                <div class="pull-right m-t-30">
                                    <p><strong>Order Date: </strong> {{$order->order_date}}</p>
                                    @if($order->order_status == '0')
                                    <p class="m-t-10"><strong>Order Status: </strong> <span class="label label-pink">Pending</span></p>
                                    @else
                                     <p class="m-t-10"><strong>Order Status: </strong> <span class="label label-success">Success</span></p>
                                    @endif
                                    <p class="m-t-10"><strong>Order ID: </strong> #{{$order->id}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="m-h-50"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                 <form action="{{URL::to('/return-value/'.$order->id)}}" method="post">
                                  @csrf
                                    <table class="table m-t-30">
                                        <thead>
                                            <tr><th>SL</th>
                                            <th>Product Name</th>
                                            <th>Product Price</th>
                                            <th>Quantity</th>
                                            <th>Return Quantity</th>
                                            <th>Unit Cost</th>
                                            
                                        </tr></thead>
                                        <tbody>
                                         @foreach($carts as $key=>$row)
                                         @php
                                           $sum = DB::table('carts')
					                            ->where('cart_session_id',$row->cart_session_id)
					                            ->sum('amount');
                                     
                                       
                                         @endphp
                                         <input type="hidden" class="qty_val" id="source_qty_val_{{$row->id}}" data-id="{{$row->id}}" value="{{$row->qty}}">
                                         <input type="hidden" name="id[]" value="{{$row->id}}">

                                            <tr>
                                                <td>{{$key+1}}</td>
                                            @if($row->cart_variant_id == NULL) 
                                            <td>{{$row->cart_pro_name}}</td>
                                            @else
                                                <td>{{$row->cart_pro_name}}(
                                                  @php
                                                 $variant = DB::table('variants')
                                            ->where('variants.id',$row->cart_variant_id)
                                            ->first();
                                          echo $variant->var_name.":"." ".$variant->var_value;
                               @endphp
                                                )</td>
                                            @endif
                                                <td>$<span class="cart_price" id="source_price_{{$row->id}}">{{$row->cart_pro_price}}</span></td>
                                                <td><span class="cart_qty" id="source_qty_{{$row->id}}">{{$row->qty}}</span> {{$row->product_unit}}
                                               <input type="hidden" name="source_qty[]" class="source_qty" value="{{$row->qty}}">   
                                                </td>
                                                <td>

                                                 <input id="source_return_{{$row->id}}" style="width: 150px;" type="text" name="return_qty[]" class="form-control return" placeholder="Return Quantity" data-id="{{$row->id}}" value="{{$row->return_qty}}"> 

                                                </td>

                                                <td>$
                                                  @if($row->return_amount == NULL)
                                                  <span id="source_amount_{{$row->id}}" class="amount">{{$row->amount}}</span>
                                                 @else
                                                  <span id="source_amount_{{$row->id}}" class="amount">{{$row->return_amount}}</span>

                                                 @endif
                                                 <input type="hidden" name="return_amount[]" class="return_amount" value="">
                                                </td>
                                                
                                            </tr>
                                         @endforeach 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> 
                        <div class="row" style="border-radius: 0px;">
                            <div class="col-md-3 col-md-offset-9">
                                 @php
                                 $return_sum = DB::table('orders')
                                   ->where('order_session_id', $order->order_session_id)
                               
                                   ->first();
                                @endphp
                                <h3 class="text-right">Return Due (USD) <span class="total">
                                  @if($return_sum->order_return_total == NULL)
                                  {{$order->order_sub_total}}
                                  @else
                                   @if($order->return_due == NULL)
                                    {{$order->order_return_total}}
                                    
                                   @else
                                    {{$order->return_due}}
                                  @endif
                                  @endif
                                </span></h3>
                            </div>
                        </div>
                        <input type="hidden" class="return_total" name="return_total" value="">


                        <div class="form-group">
                          <label for="pay">Pay</label>
                          <input type="text" id="pay" class="form-control return_pay" name="return_pay" value="{{$order->return_pay}}">
                        </div>

                        <div class="form-group">
                          <label for="due">Due</label>
                          <input type="text" id="due" class="form-control return_due" name="return_due" value="{{$order->return_due}}" readonly=""> 
                        </div>


                        <button type="submit" class="btn btn-success return_submit">Return</button>

                        


                       </form>
                        
                    </div>
                </div>

            </div>

       </div> 
      </div>
     </div>
  </div>
<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/jQuery.print.js')}}"></script>
<script>
 $(document).ready(function(){
 	$('tbody').delegate('.return', 'input', function(){
 		var id = $(this).data('id');
      
 		var tr = $(this).parent().parent();
         var price = tr.find('.cart_price').html();
         var qty = tr.find('.cart_qty').html();

         var source_qty = tr.find('.source_qty').val();

          var return_qty = tr.find('.return').val();
	 		var pre_val = $("#source_qty_val_"+id).val();
 		if(return_qty !== ''){
 			  
	 		   
         
          var final_qty = pre_val - return_qty;
           
           if(final_qty >= 0){
            $("#source_qty_"+id).html(pre_val - return_qty);
            tr.find('.amount').html(final_qty * price);
             total();
           }else{
              alert("Sorry Main Quantity Should be greater than Return Quantity");
                 tr.find('.return').val("");
                 tr.find('.cart_qty').html(pre_val);
                 tr.find('.amount').html(pre_val*price);
                 tr.find('.return_amount').val(pre_val*price);
                 tr.find('.source_qty').val(pre_val);
                 total();
           }
            
        
          
          // if(pre_val >= 10){
              
          //      var less = pre_val - 1;
              

          //      tr.find('.cart_qty').html(final_qty);
          //       var amount = (final_qty * price);
      
          //       tr.find('.amount').html(amount);
          //      if(final_qty >= 0){
          //       if(return_qty > 9){
          //          if(return_qty == less){
          //           tr.find('.cart_qty').html("1");
          //           var amount = (1 * price);
        
          //           tr.find('.amount').html(amount);
          //           tr.find('.return_amount').val(amount);
          //           tr.find('.source_qty').val("1");
          //           total();
          //         }
          //         else{
          //           tr.find('.cart_qty').html(final_qty+1);
          //          var amount = (final_qty+1 * price);
          //          tr.find('.source_qty').val(final_qty+1);
          //          tr.find('.amount').html(amount+1);
          //          tr.find('.return_amount').val(amount+1);
          //          total();
          //         }
                   
          //       }
                 
          //         else{
          //           tr.find('.cart_qty').html(final_qty);
          //          var amount = (final_qty * price);
      
          //          tr.find('.amount').html(amount);
          //          tr.find('.return_amount').val(amount);
          //           tr.find('.source_qty').val(final_qty);
          //          total();
          //         }
                   
          //      }
          //      else if(final_qty == -1){
          //          tr.find('.amount').html("0");
          //          tr.find('.return_amount').val("0");
          //          tr.find('.cart_qty').html("0");
          //          tr.find('.source_qty').val(final_qty);
          //          tr.find('.source_qty').val("0");
          //          total();
          //      }
          //      else if(final_qty < -1){
          //        alert("Sorry Main Quantity Should be greater than Return Quantity");
          //        tr.find('.return').val("");
          //        tr.find('.cart_qty').html(pre_val);
          //        tr.find('.amount').html(pre_val*price);
          //        tr.find('.return_amount').val(pre_val*price);
          //        tr.find('.source_qty').val(pre_val);
          //        total();
          //      }
          //   }
          // else{
          //    if(final_qty < 0){
          //       alert("Sorry Main Quantity Should be greater than Return Quantity");
          //       tr.find('.return').val("");
          //       tr.find('.source_qty').val(pre_val);
          //       sub_total();
          //       total();
          //     }else{
          //       tr.find('.cart_qty').html(final_qty);
          //       var amount = (final_qty * price);
      
          //       tr.find('.amount').html(amount);
          //       tr.find('.return_amount').val(amount);
          //       tr.find('.source_qty').val(final_qty);
          //       total();
          //     }
          // }
          
                  	
	 		
	 					
	 		
 		}else{
       tr.find('.cart_qty').html(pre_val);
       tr.find('.amount').html(pre_val*price);
       tr.find('.return_amount').val("");
        tr.find('.source_qty').val(pre_val);
       total();
 		} 
 		
 	});
  


 });

  

  $(function() {
        $(".total, .return_pay").on("keydown keyup", sum);
         



        function sum() {
            $(".return_due").val(Number($(".total").html()) - Number($(".return_pay").val()));
        }
    });

  
  function total(){
    var sum = 0;
             $('.amount').each(function(){

         
                sum += parseFloat($(this).html());
             

             });
             $(".return_total").val(sum);
            $(".total").html(sum);
  }


</script>

@endsection

