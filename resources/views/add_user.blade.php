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
                    <div class="panel-heading"><h3 class="panel-title">Add User</h3></div>
                    <div class="panel-body">
                        <form role="form" action="{{URL::to('/insert-user')}}" method="post">
                        @csrf


                        <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" placeholder="User Name" name="name" required>
                            </div>


                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="User Email" name="email" required>
                            </div>


                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="User Password" name="password" required>
                            </div>

                            <div class="form-group">
                                <label for="role">User Role</label>
                                <input type="text" class="form-control" id="role" placeholder="User Role" name="role" required>
                            </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <input type="checkbox" id="pos" name="pos" value="1">
                              <label for="pos">POS</label> 
                            </div>



                            <div class="form-group">
                              <input type="checkbox" id="create_user" name="create_user" value="1">
                              <label for="create_user">User</label>
                            </div>


                            <div class="form-group">
                              <input type="checkbox" id="customer" name="customer" value="1">
                              <label for="customer">Customer</label>
                            </div>


                            <div class="form-group">
                              <input type="checkbox" id="supplier" name="supplier" value="1">
                              <label for="supplier">Supplier</label>
                            </div>

                            
                             <div class="form-group">
                              <input type="checkbox" id="settings" name="settings" value="1">
                              <label for="settings">Settings</label>
                            </div>



                          </div>

                          <div class="col-md-6">

                            <div class="form-group">
                              <input type="checkbox" id="category" name="category" value="1">
                              <label for="category">Category</label>
                            </div>

                            <div class="form-group">
                              <input type="checkbox" id="product" name="product" value="1">
                              <label for="product">Product</label>
                            </div>

                            <div class="form-group">
                              <input type="checkbox" id="sale_product" name="sale_product" value="1">
                              <label for="sale_product">Sale Product</label>
                            </div>


                            <div class="form-group">
                              <input type="checkbox" id="set_order" name="set_order" value="1">
                              <label for="set_order">Order</label>
                            </div>


                            <div class="form-group">
                              <input type="checkbox" id="due_report" name="due_report" value="1">
                              <label for="due_report">Due Report</label>
                            </div>
                             

                             <div class="form-group">
                              <input type="checkbox" id="sales_report" name="sales_report" value="1">
                              <label for="sales_report">Sales Report</label>
                            </div>

                          </div>
                        </div>

                            
                            
                            
                            <button type="submit" class="btn btn-purple waves-effect waves-light">Submit</button>
                        </form>
                    </div><!-- panel-body -->
                </div> <!-- panel -->
            </div> <!-- col-->




        </div>

      </div>
   </div>
 </div>

 
 
@endsection