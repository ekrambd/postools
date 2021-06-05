<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\RoleController;
/*
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



 
Route::get('/', function(){
	return view('welcome');
});

Route::get('/dashboard', [WelcomeController::class, 'Dashboard']);
//admin regsieter or login
Route::post('/admin-login', [AccessController::class, 'AdminLogin']);

Route::get('/logout', [AccessController::class, 'logout']);
// Route::get('/admin-insert', [AccessController::class, 'AdminInsert']);
// Route::post('/insert-user', [AccessController::class, 'InsertUser']);

//category
Route::get('/add-category', [CategoryController::class, 'AddCategory']);
Route::post('/insert-category', [CategoryController::class, 'InsertCategory']);
Route::get('/all-category', [CategoryController::class, 'AllCategory']);
Route::get('/edit-category/{id}', [CategoryController::class, 'EditCategory']);
Route::post('/update-category/{id}', [CategoryController::class, 'UpdateCategory']);
Route::get('/delete-category/{id}',[CategoryController::class, 'DelereCategory']);

//customer
Route::get('/add-customer', [CustomerController::class, 'AddCustomer']);
Route::get('/all-customer', [CustomerController::class, 'AllCustomer']);
Route::post('/insert-customer', [CustomerController::class, 'InsertCustomer']);
Route::get('/edit-customer/{id}', [CustomerController::class, 'EditCustomer']);
Route::post('/update-customer/{id}', [CustomerController::class, 'UpdateCustomer']);
Route::get('/delete-customer/{id}', [CustomerController::class, 'DeleteCustomer']);

//product
Route::get('/add-product', [ProductController::class, 'AddProduct']);
Route::post('/insert-product', [ProductController::class, 'InsertProduct']);
Route::get('/all-product', [ProductController::class, 'AllProduct']);
Route::get('/edit-product/{id}', [ProductController::class, 'EditProduct']);
Route::get('/delete-product/{id}', [ProductController::class, 'DeleteProduct']);
Route::post('/update-product/{id}',[ProductController::class, 'UpdateProduct']);
Route::get('/remove-image/{id}', [ProductController::class, 'RemoveImage']);
Route::get('/remove/{id}',[ProductController::class, 'Remove']);

//pos
Route::get('/pos', [PosController::class, 'Pos']);


//cart
Route::get('/add-to-cart/{id}/{qty}', [CartController::class, 'AddCart']);
Route::get('/scan-barcode/{val}', [CartController::class, 'ScanBarcode']);
Route::get('/cart-remove/{id}', [CartController::class, 'CartRemove']);

Route::get('/discount', [CartController::class, 'Discount']);
Route::get('/increment/{id}/{qty}', [CartController::class, 'Increment']);
Route::get('/decrement/{id}/{qty}', [CartController::class, 'Decrement']);
Route::get('/category-details/{id}', [CartController::class, 'CategoryDetails']);
Route::get('/products', [CartController::class, 'Products']);
Route::get('/cart-destroy', [CartController::class, 'CartDestory']);


//manual sale
Route::get('/sale-product', [SaleController::class, 'SaleProduct']);

Route::get('/scan-product/{scan}', [SaleController::class, 'ScanProduct']);
Route::get('/scan-sale_barcode/{scan}', [SaleController::class, 'ScanSaleBarcode']); 

//order
Route::post('/store-order', [OrderController::class, 'StoreOrder']);
Route::get('/invoice-list', [OrderController::class, 'InvoiceList']);
Route::get('/view-invoice/{id}', [OrderController::class, 'ViewInvoice']);
Route::get('/approve-order/{order_session_id}',[OrderController::class, 'ApproveOrder']);
Route::get('/cancel-order/{order_session_id}', [OrderController::class, 'CancelOrder']);

//Due && Sales Report
Route::get('/customer-due', [ReportController::class, 'CustomerDue']);
Route::get('/customer-due-report/{id}', [ReportController::class, 'CustomerDueReport']);
Route::get('/due-collection/{id}', [ReportController::class, 'DueCollection']);
Route::get('/collect-due/{id}', [ReportController::class, 'CollectDue']);
Route::get('/today-due', [ReportController::class, 'TodayDue']);
Route::get('/load-due_collection/{id}', [ReportController::class, 'LoadDueCollection']);
Route::post('/load-collect_due/{id}', [ReportController::class, 'LoadCollectDue']);
Route::get('/daily-due', [ReportController::class, 'DailyDue']);
Route::get('/daily-due_collection', [ReportController::class, 'DailyDueCollection']);
Route::get('/daily-collect-due/{id}', [ReportController::class, 'DailyCollectDue']);
Route::get('/mothly-due', [ReportController::class, 'MonthlyDue']);
Route::get('/monthly-due-report', [ReportController::class, 'MonthlyDueReport']);
Route::get('/monthly_due-collection/{id}', [ReportController::class, 'MonthlyDueCollection']);
Route::get('/monthly_collect-due/{id}', [ReportController::class, 'MonthlyCollectDue']);
Route::get('/yearly-due', [ReportController::class, 'YearlyDue']);
Route::get('/yearly-due-report', [ReportController::class, 'YearlyDueReport']);
Route::get('/yearly_collect-due/{id}', [ReportController::class, 'YearlyCollectDue']);

//Sales Report
Route::get('/today-sales', [ReportController::class, 'TodaySales']);
Route::get('/monthly-sales', [ReportController::class, 'MonthlySales']);
Route::get('/monthly-sales-report', [ReportController::class, 'MonthlySalesReport']); 
Route::get('/daily-sales', [ReportController::class, 'DailySales']);
Route::get('/daily-sales-report', [ReportController::class, 'DailySalesReport']);
Route::get('/yearly-sales', [ReportController::class, 'YearlySales']);
Route::get('/yearly-sales-report',[ReportController::class, 'YearlySalesReport']);

//web settings
Route::get('/change-password', [SettingsController::class,'ChangePassword']);
Route::post('/password-chnage', [SettingsController::class,'PasswordChange']);
Route::get('/profile-settings', [SettingsController::class,'ProfileSettings']);
Route::post('/update-profile/{id}', [SettingsController::class,'UpdateProfile']);

//sales return
Route::get('/return-sales/{id}', [ReturnController::class,'ReturnSales']);
Route::post('/return-value/{id}', [ReturnController::class,'ReturnValue']);

//User Role Management
Route::get('/add-user', [RoleController::class,'AddUser']);
Route::post('/insert-user', [RoleController::class,'InsertUser']);
Route::get('/all-user', [RoleController::class,'AllUser']);
Route::get('/edit-user/{id}', [RoleController::class,'EditUser']);
Route::post('/update-user/{id}', [RoleController::class,'UpdateUser']);
Route::get('/delete-user/{id}', [RoleController::class,'DeleteUser']);