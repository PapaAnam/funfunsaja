<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity;
use Auth;

class ActivityController extends Controller
{

	public function index()
	{
		$activities 	= Activity::myActivities(Auth::id());
		$oper 			= [
			'activities'	=> $activities,
		];
		return view('activities.index', $oper);
	}

}
