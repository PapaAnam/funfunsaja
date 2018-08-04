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

    public function verifikasiKtp(UserBio $userBio, Request $r)
    {
        $r->validate([
            'keterangan'=>'required',
        ]);
    	$userBio->update([
    		'nin_valid'=>'1',
            'keterangan_ktp'=>$r->keterangan,
    	]);
    	return 'KTP berhasil diverifikasi';
    }

    public function tolakKtp(UserBio $userBio, Request $r)
    {
        $r->validate([
            'keterangan'=>'required',
        ]);
    	$userBio->update([
    		'nin_valid'=>'2',
            'keterangan_ktp'=>$r->keterangan,
    	]);
    	return 'KTP berhasil ditolak';
    }

}
