<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Province;
use App\Village;
use App\City;
use App\Region;
use App\Other;
use Hash;

class CVMemberController extends Controller
{
    public function index($username)
    {
    	$user = User::where('username', $username)->first();
    	if(is_null($user))
    		abort(404);
		$bank = $user->bank()->where('status', '1')->first();
		$bio = $user->bio()->where('status', '1')->first();
		$biodata = $user->biodata()->where('status', '1')->first();
		$biography = $user->biography()->where('status', '1')->first();
		$skills = Other::where('category', 'skill')->get();
		$passions = Other::where('category', 'passion')->get();
		$hobbies = Other::where('category', 'hobby')->get();
		$languages = Other::where('category', 'language')->get();
		$characters = Other::where('category', 'character')->get();
		$user2 = collect($user->only('username', 'description', 'web', 'email', 'phone_number', 'id', 'avatar'));
		$data =  [
			'user' 			=> $user2,
			'pass_is_same' 	=> Hash::check($user->token_number, $user->password),
			'my_bank' 		=> $bank,
			'my_bio' 		=> $bio,
			'provinces' 	=> Province::where('IDProvinsi', '!=', '0')->orderBy('Nama')->get(),
			'cities' 		=> $bio ? City::where('IDProvinsi', $bio->province_id)->orderBy('Nama')->get(): json_encode([]),
			'regions' 		=> $bio ? Region::where('IDKabupaten', $bio->city_id)->orderBy('Nama')->get(): json_encode([]),
			'villages' 		=> $bio ? Village::where('IDKecamatan', $bio->region_id)->orderBy('Nama')->get(): json_encode([]),
			'biodata' 		=> $biodata,
			'biography' 	=> $biography,
			'skills' 		=> $skills,
			'passions' 		=> $passions,
			'hobbies' 		=> $hobbies,
			'languages' 	=> $languages,
			'characters' 	=> $characters,
		];
    	return view('admin.member.cv', $data);
    }
}
