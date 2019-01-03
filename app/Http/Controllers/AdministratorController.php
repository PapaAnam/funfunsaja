<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministratorController extends Controller
{

	public function __construct()
	{
		$this->middleware('admin');
	}

	public function index()
	{
		return redirect('admin-menu');
	}

}
