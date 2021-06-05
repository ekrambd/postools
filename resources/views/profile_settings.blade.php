@extends('master')
@section('content')
 <div class="content-page">
   <div class="content">
      <div class="container">
       
       <div class="row">
	        <div class="col-sm-12">
	            <h4 class="pull-left page-title">Profile Settings</h4>
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
                    <div class="panel-heading"><h3 class="panel-title">Update Your Profile</h3></div>
                    <div class="panel-body">
                        <form role="form" action="{{URL::to('/update-profile/'.$user->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="{{$user->name}}">
                            </div>


                           <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{$user->email}}">
                            </div>

                            <div class="row">

                             <div class="col-md-6">
                              
                                <label for="profile_pic">Profile Picture</label>
                               <input type="file" name="profile_pic" class="form-control"  accept="image/*"  id="profile_pic" onchange="readURL(this);">
                             
                             </div> 


                             <div class="col-md-6">
                              
                              <img id="image" style="width: 60px; height: 60px;" src="{{URL::to($user->profile_pic)}}">
                             
                             </div> 	

                             

                            </div>
                            
                            
                            <button type="submit" class="btn btn-success waves-effect waves-light">Update Profile</button>
                        </form>
                    </div><!-- panel-body -->
                </div> <!-- panel -->
            </div> <!-- col-->




        </div>

      </div>
   </div>
 </div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript">
  function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              $('#image')
                  .attr('src', e.target.result)
                  .width(80)
                  .height(80);
          };
          reader.readAsDataURL(input.files[0]); 
      }
   }

   
</script>
 
 
@endsection