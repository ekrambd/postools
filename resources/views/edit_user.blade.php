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
                    <div class="panel-heading"><h3 class="panel-title">Update User</h3></div>
                    <div class="panel-body">
                        <form role="form" action="{{URL::to('/update-user/'.$edit->id)}}" method="post">
                        @csrf


                        <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" placeholder="User Name" name="name" value="{{$edit->name}}">
                            </div>


                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="User Email" name="email" value="{{$edit->email}}">
                            </div>



                            <div class="form-group">
                                <label for="role">User Role</label>
                                <input type="text" class="form-control" id="role" placeholder="User Role" name="role" value="{{$edit->role}}">
                            </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <input type="checkbox" id="pos" name="pos" value="1" <?php if($edit->pos == 1){echo "checked";} ?>>
                              <label for="pos">POS</label> 
                            </div>



                            <div class="form-group">
                              <input type="checkbox" id="create_user" name="create_user" value="1" <?php if($edit->create_user == 1){echo "checked";} ?>>
                              <label for="create_user">User</label> 
                            </div>


                            <div class="form-group">
                              <input type="checkbox" id="customer" name="customer" value="1" <?php if($edit->customer == 1){echo "checked";} ?>>
                              <label for="customer">Customer</label>
                            </div>


                            <div class="form-group">
                              <input type="checkbox" id="supplier" name="supplier" value="1" <?php if($edit->supplier == 1){echo "checked";} ?>>
                              <label for="supplier">Supplier</label>
                            </div>

                            
                             <div class="form-group">
                              <input type="checkbox" id="settings" name="settings" value="1" <?php if($edit->settings == 1){echo "checked";} ?>>
                              <label for="settings">Settings</label>
                            </div>



                          </div>

                          <div class="col-md-6">

                            <div class="form-group">
                              <input type="checkbox" id="category" name="category" value="1" <?php if($edit->category == 1){echo "checked";} ?>>
                              <label for="category">Category</label>
                            </div>

                            <div class="form-group">
                              <input type="checkbox" id="product" name="product" value="1" <?php if($edit->product == 1){echo "checked";} ?>>
                              <label for="product">Product</label>
                            </div>

                            <div class="form-group">
                              <input type="checkbox" id="sale_product" name="sale_product" value="1" <?php if($edit->sale_product == 1){echo "checked";} ?>>
                              <label for="sale_product">Sale Product</label>
                            </div>


                            <div class="form-group">
                              <input type="checkbox" id="set_order" name="set_order" value="1" <?php if($edit->set_order == 1){echo "checked";} ?>>
                              <label for="set_order">Order</label>
                            </div>


                            <div class="form-group">
                              <input type="checkbox" id="due_report" name="due_report" value="1" <?php if($edit->due_report == 1){echo "checked";} ?>>
                              <label for="due_report">Due Report</label>
                            </div>
                             

                             <div class="form-group">
                              <input type="checkbox" id="sales_report" name="sales_report" value="1" <?php if($edit->sales_report == 1){echo "checked";} ?>>
                              <label for="sales_report">Sales Report</label>
                            </div>

                          </div>
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