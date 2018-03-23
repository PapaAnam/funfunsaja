<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
	use \App\Helpers\Api;

	protected function model()
	{
		$data = \App\Activity::with('admin', 'user')->where('title', 'NOT LIKE', 'Moderasi%');
		return $data;
	}
}
