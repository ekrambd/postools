@extends('master')
@section('content')
 <div class="content-page">
   <div class="content">
      <div class="container">
         <div class="row">
         	<div class="col-sm-12">
	            <h4 class="pull-left page-title">All Product</h4>
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
           	 		
           	 		<a  href="{{URL::to('/add-product')}}" class="btn btn-info">Add Product</a>
           	 	</div>
                <div class="panel-body">
                   <table id="datatable" class="table table-striped table-bordered">
                   	 <thead>
                   	 	<tr>
                   	 	 <th>SL</th>
                   	 	 <th>Image</th>
                   	 	 
                   	 	 <th>Product Name</th>
                   	 	 
                   	 	 <th>Product Price</th>
                   	 	 <th>Action</th>
                   	 	</tr>
                   	 </thead>
                   	 <tbody>
                   	  @foreach($all as $key => $row)
                   	 	<tr>
                   	 	  <td>{{$key+1}}</td>
                   	 	 <td>
                   	 	  <img style="width: 60px; height: 60px;" src="{{URL::to($row->product_image)}}">	
                   	 	 </td>
                   	 	 
                   	 	 
                   	 	  <td>{{$row->product_name}}</td>
                   	 	  
                   	 	  <td>${{$row->product_price}}</td>
                   	 	  <td>
                   	 	  	<a href="{{URL::to('/edit-product/'.$row->id)}}" class="btn btn-info btn-sm">Edit</a>
                   	 	  	<a href="{{URL::to('/delete-product/'.$row->id)}}" id="delete" class="btn btn-danger btn-sm">Delete</a>
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