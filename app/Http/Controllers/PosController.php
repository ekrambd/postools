<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class PosController extends Controller
{   
	public function __construct()
    {
        $this->middleware('auth_check');
    }
    public function pos()
    {
    	return view('pos');
    }
}
