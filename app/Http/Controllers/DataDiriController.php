<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserBio;

class DataDiriController extends Controller
{

    public function get(Request $r)
    {
    	$data = UserBio::where('user_id', $r->id_user)->where('status', '1')->first();
    	return is_null($data) ? 'nothing' : $data;
    }

    public function verifikasiKtp(UserBio $userBio)
    {
    	$userBio->update([
    		'nin_valid'=>'1'
    	]);
    	return 'KTP berhasil diverifikasi';
    }

    public function tolakKtp(UserBio $userBio)
    {
    	$userBio->update([
    		'nin_valid'=>'2'
    	]);
    	return 'KTP berhasil ditolak';
    }

}
