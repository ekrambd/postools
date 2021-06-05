<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_check');
    }
}
