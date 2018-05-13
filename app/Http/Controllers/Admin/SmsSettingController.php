<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;

class SmsSettingController extends Controller
{

	public function index()
	{
		return Setting::firstOrCreate([
			'key'		=> 'sms'
		], [
			'value'		=> json_encode([
				'SMS_ME_EMAIL'		=> 'funzy.com@gmail.com',
				'SMS_ME_PASSWORD'	=> 'Jogja021214',
				'SMS_ME_DEVICE'		=> '79605',
			]),
		])->value;
	}

	public function update(Request $r)
	{
		$r->validate([
			'SMS_ME_EMAIL'		=> 'required|email',
			'SMS_ME_PASSWORD'	=> 'required',
			'SMS_ME_DEVICE'		=> 'required|numeric',
		]);
		Setting::updateOrCreate([
			'key'		=> 'sms'
		], [
			'value'		=> json_encode([
				'SMS_ME_EMAIL'		=> $r->SMS_ME_EMAIL,
				'SMS_ME_PASSWORD'	=> $r->SMS_ME_PASSWORD,
				'SMS_ME_DEVICE'		=> $r->SMS_ME_DEVICE,
			]),
		]);
		return 'Pengaturan SMS berhasil diperbarui';
	}

}
