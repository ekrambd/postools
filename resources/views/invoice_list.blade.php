@extends('master')
@section('content')
 <div class="content-page">
   <div class="content">
      <div class="container">
         <div class="row">
         	<div class="col-sm-12">
	            <h4 class="pull-left page-title">All Category</h4>
	            <ol class="breadcrumb pull-right">
	                <li><a href="#">Moltran</a></li>
	                <li><a href="#">Forms</a></li>
	                <li class="active">General elements</li>
	            </ol>
	        </div>
         </div>
         <div class="row">
           
           <div class="col-md-12">

           	 <div class="panel panel-default">
           	 	<div class="panel-heading">
           	 		
           	 		<a  href="{{URL::to('/pos')}}" class="btn btn-info">POS</a>
           	 	</div>
                <div class="panel-body">
                   <table id="datatable" class="table table-striped table-bordered">
                   	 <thead>
                   	 	<tr>
                   	 	 <th>SL</th>
                   	 	
                   	 	 <th>Customer Name</th>
                   	 	 <th>Sub Total</th>
                   	 	 <th>Discount</th>
                   	 	 <th>Vat</th>
                   	 	  <th>Total</th>
                   	 	  <th>Pay</th>
                   	 	  <th>Due</th>
                   	 	 <th>Action</th>
                   	 	</tr>
                   	 </thead>
                   	 <tbody>
                   	  @foreach($all as $key => $row)
                   	 	<tr>
                   	 	  <td>{{$key+1}}</td> 
                   	 	  
                   	 	  <td>{{$row->customer_name}}</td>
                   	 	  <td>${{$row->order_sub_total}}</td>
                   	 	   @if(strpos($row->discount, '%') !== false)
                   	 	      
                   	 	  <td>{{$row->discount}}</td>

                   	 	  @else
                   	 	   <td>${{$row->discount}}</td>
                   	 	  @endif
                   	 	  <td>5%</td>
                   	 	  <td>${{$row->order_total}}</td>
                   	 	  <td>${{$row->pay}}</td>
                   	 	  <td>${{$row->due}}</td>
                   	 	  <td>
                   	 	  	<a href="{{URL::to('/view-invoice/'.$row->id)}}" class="btn btn-success btn-sm">View Invoice</a> 

                          <a href="{{URL::to('/return-sales/'.$row->id)}}" class="btn btn-info btn-sm">Sales Return</a> 
                   	 	  
                   	 	  </td>
                   	 	</tr>
                   	 @endforeach
                   	 </tbody>
                   </table>
                </div>
           	 </div>

           </div>

         </div>
      </div>
   </div>
 </div>

@endsection