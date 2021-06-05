<html>
  <head>
     
    <!-- Base Css Files -->
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" />

        <!-- Font Icons -->
        <link href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" />
        <link href="{{asset('assets/ionicon/css/ionicons.min.css')}}" rel="stylesheet" />
        <link href="{{asset('css/material-design-iconic-font.min.css')}}" rel="stylesheet">

        <!-- animate css -->
        <link href="{{asset('css/animate.css')}}" rel="stylesheet" />

        <!-- Waves-effect -->
       <!--  <link href="{{asset('css/waves-effect.css')}}" rel="stylesheet"> -->

        <!-- Custom Files -->
        <!-- <link href="{{asset('css/helper.css')}}" rel="stylesheet" type="text/css" /> -->
        <link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="{{asset('js/modernizr.min.js')}}"></script>

</head>
 <body>
  
    
    
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
            <div class="col-md-12" id="printarea">
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
                                     <p class="m-t-10"><strong>Order Status: </strong> <span class="label label-pink">Success</span></p>
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
                                              
                                                <td>{{$row->cart_pro_name}}</td>

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
                                <p class="text-right"><b>Discount:</b> ${{$order->discount}}</p>
                                 <p class="text-right">Vat: 5%</p>
                                <p class="text-right"><b>Total:</b> ${{$order->order_total}}</p>
                               
                                <hr>
                                <h3 class="text-right">USD {{$order->order_total}}</h3>
                            </div>
                        </div>
                        <hr>
                        <div class="hidden-print">
                            <div class="pull-right">
                                <button type="button" class="btn btn-inverse waves-effect waves-light print" ><i class="fa fa-print"></i></button>
                                <a href="#" class="btn btn-danger waves-effect waves-light">Cancel Order</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

       </div>
  
   

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->

        <script src="{{asset('js/jquery.min.js')}}"></script>
        
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        <script src="{{asset('js/waves.js')}}"></script>
        <script src="{{asset('js/wow.min.js')}}"></script>
        <script src="{{asset('js/jquery.nicescroll.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/jquery.scrollTo.min.js')}}"></script>
        <script src="{{asset('assets/chat/moment-2.2.1.js')}}"></script>
        <script src="{{asset('assets/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
        <script src="{{asset('assets/jquery-detectmobile/detect.js')}}"></script>
        <script src="{{asset('assets/fastclick/fastclick.js')}}"></script>
        <script src="{{asset('assets/jquery-slimscroll/jquery.slimscroll.js')}}"></script>
        <script src="{{asset('assets/jquery-blockui/jquery.blockUI.js')}}"></script>

        <script src="{{ asset('assets/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/datatables/dataTables.bootstrap.js') }}"></script>
        
        <script type="text/javascript">
            $(document).ready(function() {
                $('#datatable').dataTable();
            } );
        </script>
       

        <!-- Counter-up -->
        <script src="{{asset('assets/counterup/waypoints.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/counterup/jquery.counterup.min.js')}}" type="text/javascript"></script>
        
        <!-- CUSTOM JS -->
        <script src="{{asset('js/jquery.app.js')}}"></script>

        <!-- Dashboard -->
        <script src="{{asset('js/jquery.dashboard.js')}}"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

        <script type="text/javascript">
            /* ==============================================
            Counter Up
            =============================================== */
            jQuery(document).ready(function($) {
                $('.counter').counterUp({
                    delay: 100,
                    time: 1200
                });
            });
        </script>


          <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
         <script src="{{asset('https://unpkg.com/sweetalert/dist/sweetalert.min.js')}}"></script>


        <script>
      @if(Session::has('messege'))
        var type="{{Session::get('alert-type','info')}}"
        switch(type){
            case 'info':
                 toastr.info("{{ Session::get('messege') }}");
                 break;
            case 'success':
                toastr.success("{{ Session::get('messege') }}");
                break;
            case 'warning':
                toastr.warning("{{ Session::get('messege') }}");
                break;
            case 'error':
                toastr.error("{{ Session::get('messege') }}");
                break;
        }
      @endif
    </script>
    
 
<script>
  myFunction();
  window.onafterprint = function(e){
     window.close()
  };
  function myFunction(){
    window.print();
  }
  function closePrintView()
  {
     //window.location.href="all-product_super_show"; 
     window.close()
     
  }
</script>
 </body>
</html>