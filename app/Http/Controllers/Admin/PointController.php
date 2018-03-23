<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Point;

class PointController extends Controller
{

	use \App\Helpers\Api;

    protected function model()
    {
    	return Point::with('user', 'content');
    }

}
