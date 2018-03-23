<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SummernoteController extends Controller
{
    public function __invoke(Request $r)
    {
    	return asset('storage/'.upload($r->file('file'), 'public/images'));
    }
}
