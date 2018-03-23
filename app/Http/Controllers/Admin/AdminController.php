<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdminController extends Controller
{

	public function profile()
	{
		return Auth::guard('admin')->user();
	}

}
