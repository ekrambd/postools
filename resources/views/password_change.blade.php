@extends('master')
@section('content')
 <div class="content-page">
   <div class="content">
      <div class="container">
       
       <div class="row">
	        <div class="col-sm-12">
	            <h4 class="pull-left page-title">Password Change</h4>
	            <ol class="breadcrumb pull-right">
	                <li><a href="#">Moltran</a></li>
	                <li><a href="#">Forms</a></li>
	                <li class="active">Password Change</li>
	            </ol>
	        </div>
        </div>
        

        <div class="row">
         

          <!-- Basic example -->
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="panel-title">Change Your Passpword</h3></div>
                    <div class="panel-body">
                        <form role="form" action="{{URL::to('/password-chnage')}}" method="post">
                        @csrf
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" class="form-control" id="current_password" placeholder="Current Password" name="current_password" required>
                            </div>


                           <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" class="form-control" id="new_password" placeholder="Current Password" name="new_password" required>
                            </div>

                            
                            
                            
                            <button type="submit" class="btn btn-success waves-effect waves-light">Change Password</button>
                        </form>
                    </div><!-- panel-body -->
                </div> <!-- panel -->
            </div> <!-- col-->




        </div>

      </div>
   </div>
 </div>

 
 
@endsection