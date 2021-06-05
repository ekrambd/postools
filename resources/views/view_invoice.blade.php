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
                                    <table class="table m-t-30">
                                        <thead>
                                            <tr><th>SL</th>
                                            <th>Product Name</th>
                                            <th>Product Price</th>
                                            <th>Quantity</th>
                                            <th>Unit Cost</th>
                                            
                                        </tr></thead>
                                        <tbody>
                                         @foreach($carts as $key=>$row)
                                         @php
                                           $sum = DB::table('carts')
					                            ->where('cart_session_id',$row->cart_session_id)
					                            ->sum('amount');
                                     
                                       
                                         @endphp
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
                                                <td>${{$row->cart_pro_price}}</td>
                                                <td>{{$row->qty}} {{$row->product_unit}}</td>
                                                <td>${{$row->amount}}</td>
                                                
                                            </tr>
                                         @endforeach 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> 
                        <div class="row" style="border-radius: 0px;">
                            <div class="col-md-3 col-md-offset-9">
                                <p class="text-right"><b>Sub-total:</b> ${{$order->order_sub_total}}</p>
                                @if($order->discount == NULL)
                                @else
                                <p class="text-right"><b>Discount:</b> ${{$order->discount}}</p>
                                @endif
                                 <p class="text-right">Vat: 5%</p>
                                <p class="text-right"><b>Total:</b> ${{$order->order_total}}</p>
                               
                                <hr>
                                <h3 class="text-right">USD {{$order->order_total}}</h3>
                            </div>
                        </div>
                        <hr>
                        <div class="hidden-print">
                            <div class="pull-right">
                                <button type="button" class="btn btn-inverse waves-effect waves-light print" onclick="printDiv('printableArea')"><i class="fa fa-print"></i></button>
                                @if($order->order_status == 1)
                                 <a href="{{URL::to('/cancel-order/'.$order->order_session_id)}}" class="btn btn-danger">Cancel Order</a>
                                @else
                                <a href="{{URL::to('/approve-order/'.$order->order_session_id)}}" class="btn btn-success waves-effect waves-light">Approved</a>
                                @endif
                            </div>
                        </div>
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
 
 function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}


</script>
@endsection

