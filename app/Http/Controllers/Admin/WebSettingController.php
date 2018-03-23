<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;
use Storage;

class WebSettingController extends Controller
{
	public function api()
	{
		$web = Setting::where('key', 'web')->first();
		if($web){
			$web = collect(json_decode($web->value))->transform(function($item, $key){
				if($key == 'logo' || $key == 'favicon')
					return substr($item, 0, 3) == 'pub' ? asset('storage/'.str_replace('public/', '', $item)) : asset('storage/'.$item);
				return $item;
			});
		}
		return $web;
	}

	public function update(Request $r)
	{
		// return $r->all();
		$r->validate([
			'address' => 'required',
			'city' => 'required',
			'email' => 'required|email',
			'logo_title' => 'required',
			'phone_number' => 'required',
			'post_code' => 'required',
			'seo_author' => 'required',
			'seo_description' => 'required',
			'seo_keyword' => 'required',
			'state' => 'required',
			'title' => 'required',
			'favicon' => 'nullable|file|mimes:ico|max:500',
			'logo' => 'nullable|file|mimes:png,jpeg|max:1000',
		]);
		$data = [];
		$s = collect(json_decode(Setting::where('key', 'web')->first()->value));
		// dd($s);
		if($r->file('favicon')){
			Storage::deleteDirectory('public/favicon');
			$data['favicon'] = str_replace('public/', '', $r->file('favicon')->store('public/favicon'));
		}else{
			$data['favicon'] = isset($s['favicon']) ? $s['favicon'] : null;
		}
		if($r->file('logo')){
			Storage::deleteDirectory('public/logo');
			$data['logo'] = str_replace('public/', '', $r->file('logo')->store('public/logo'));
		}else{
			$data['logo'] = isset($s['logo']) ? $s['logo'] : null;
		}
		Setting::where('key', 'web')->updateOrCreate([
			'key' => 'web'
		], [
			'value' => collect($r->except(['_method', 'logo', 'favicon'])+$data)->toJson()
		]);
		return 'Pengaturan web berhasil diperbarui';
	}
}
