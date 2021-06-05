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
                    <div class="panel-heading"><h3 class="panel-title">Update Category</h3></div>
                    <div class="panel-body">
                        <form role="form" action="{{URL::to('/update-category/'.$edit->id)}}" method="post">
                        @csrf
                            <div class="form-group">
                                <label for="name">Category Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Category Name" name="category_name" value="{{$edit->category_name}}">
                            </div>



                            
                            
                            
                            <button type="submit" class="btn btn-success waves-effect waves-light">Update</button>
                        </form>
                    </div><!-- panel-body -->
                </div> <!-- panel -->
            </div> <!-- col-->




        </div>

      </div>
   </div>
 </div>

 
 
@endsection