<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

class BankAccountController extends UserController
{
    public function index(Request $r)
    {
    	return view('user_profile.bank-account.index', $this->useroper($r)+[
    		'bank'	=> $r->user()->bank()->active()->first()
    	]);
    }

    public function edit(Request $r)
    {
    	return view('user_profile.bank-account.edit', $this->useroper($r)+[
    		'bank'	=> $r->user()->bank()->active()->first()
    	]);
    }
}
