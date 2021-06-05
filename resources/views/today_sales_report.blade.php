@extends('master')
@section('content')
 <div class="content-page">
   <div class="content">
      <div class="container">
         <div class="row">
         	<div class="col-sm-12">
	            <h4 class="pull-left page-title">Today's ({{date('d F Y')}}) Total Sales: ${{$total}}</h4>
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
           	 	
                <div class="panel-body">
                   <table id="datatable" class="table table-striped table-bordered">
                   	 <thead>
                   	 	<tr>
                   	 	 <th>SL</th>
                   	 	 <th>Customer Name</th>
                   	 	 <th>Order Total</th>
                   	 	 <th>Pay</th>
                   	 	 <th>Due</th>
                   	 	 <th>Action</th>
                   	 	</tr>
                   	 </thead>
                   	 <tbody>
                   	  @foreach($today as $key => $row)
                   	 	<tr>
                   	 	  <td>{{$key+1}}</td>
                   	 	  <td>{{$row->customer_name}}</td>
                   	 	  <td>{{$row->order_total}}</td>
                   	 	  <td>${{$row->pay}}</td>
                   	 	  <td>${{$row->due}}</td>
                   	 	  <td>
                   	 	  	<a href="{{URL::to('/load-due_collection/'.$row->id)}}" class="btn btn-info btn-sm">Due Collection</a>
                   	 	  
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