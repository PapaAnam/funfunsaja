<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Api;
use App\DepositClaimLog;

class DepositClaimController extends Controller
{
    use Api;

    protected function model()
    {
    	return DepositClaimLog::with('user');
    }
}
