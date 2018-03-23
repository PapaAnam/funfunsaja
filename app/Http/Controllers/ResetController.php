<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ResetController extends Controller
{
    public function execute()
    {
    	DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    	$tables = ['activities', 'admins', 'deposits', 'bank_accounts', 'comments', 'contents', 'feedbacks', 'notifications', 'pages', 'tags', 'testimoni', 'users', 'user_bank_accounts', 'user_biodatas', 'user_biographies', 'user_bios', 'deposit_claim_logs', 'points', 'point_claims', 'premium_logs'];
    	foreach ($tables as $t) {
	    	DB::table($t)->truncate();
    	}
    	DB::table('admins')->insert([
    		'username'	=> 'admin',
    		'password'	=> bcrypt('admin')
    	]);
        return 'RESET BERHASIL';
    }
}
