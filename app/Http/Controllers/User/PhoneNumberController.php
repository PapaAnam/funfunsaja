<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Events\UpdatePhoneNumber;
use Auth;

class PhoneNumberController extends UserController
{
    public function index(Request $r)
	{
		return view('user_profile.edit-phone-number', $this->useroper($r));
	}

	public function updatePhoneNumber(Request $r)
	{
		$token = $this->generateToken();
		$r->validate([
			'phone_number' => 'numeric|unique:users'
		]);
		$user 	= $r->user();
		$email 	= $user->email;
		$user->update([
			'token_number' 			=> $token,
			'verification_url' 		=> url('/user-verification/'.md5(str_random(20)).'?phone-number=update'),
			'last_time_to_verify' 	=> date('Y-m-d H:i:s', strtotime('+2 hours')),
			'phone_number' 			=> $r->phone_number,
			'status' 				=> '0',
		]);
		$user 	= $r->user();
		if(app()->environment() != 'local')
			event(new UpdatePhoneNumber($user));
		$r->user()->activities()->create([
			'title'		=> 'Profil',
			'content'	=> 'Memperbarui no hp',
		]);
		Auth::logout();
		return 'No Hp berhasil diubah. Tautan verifikasi sudah dikirim ke '.$email.' dan token ke '.$r->phone_number.' untuk verifikasi ulang';
	}
}
