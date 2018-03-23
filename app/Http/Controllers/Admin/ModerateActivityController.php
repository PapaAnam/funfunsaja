<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ModerateActivityController extends Controller
{
    use \App\Helpers\Api;

    protected function model()
    {
    	return \App\Activity::with('admin')->where('title', 'LIKE', 'Moderasi%');
    }
}
