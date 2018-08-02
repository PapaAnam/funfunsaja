<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserProfile;
use App\Http\Requests\UpdateUserBiodata;
use App\Http\Requests\UpdateUserBank;
use App\Http\Requests\UpdateUserBio;
use App\Http\Requests\UpdatePassword;
use App\Http\Requests\UpdateEmail;
use Illuminate\Http\Request;
use App\UserBank;
use App\Province;
use App\Village;
use App\Region;
use App\Other;
use App\City;
use App\User;
use App\Setting;
use Auth;
use Hash;
use App\Traits\RightMenu;
use App\Content;
use App\Traits\Token;
use App\Events\SendLinkAndSms;

class UserController extends Controller
{
	use RightMenu, Token;

	private function oper($r){
		$user = $r->user();
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
		// dd($user2);
		return [
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
	}

	public function index(Request $r)
	{
		$user = $r->user();
		return view('all-user.user-profile', [
			'user'				=> $user,
			'contents_count'	=> Content::where('user_id', $user->id)->published()->count(),
			'contents'			=> Content::where('user_id', $user->id)->published()->take(10)->latest()->get(),
		]+$this->getRightMenu());
		// return view('user_profile.view', $oper);
	}

	public function other(Request $r)
	{
		return view('user_profile.other', $this->oper($r));
	}

	public function edit(Request $r)
	{
		$user = Auth::user();
		$oper = [
			'user' => collect($user->only('username', 'description', 'web')),
		];
		return view('user_profile.edit', $oper);
	}

	public function update(UpdateUserProfile $r)
	{
		$data = $r->only([ 'username', 'description', 'web' ]);
		$r->user()->update($data);
		$r->user()->activities()->create([
			'title'		=> 'Profil',
			'content'	=> 'Memperbarui profil',
		]);
		return 'Profil berhasil diperbarui';
	}

	public function editPass(Request $r)
	{
		return view('user_profile.edit_pass', $this->useroper($r));
	}

	protected function useroper($r)
	{
		$user = $r->user();
		$oper = [
			'user'	=> $user,
			'contents_count'	=> Content::where('user_id', $user->id)->published()->count(),
		]+$this->getRightMenu();
		return $oper;
	}

	public function updatePass(UpdatePassword $r)
	{
		$token = $this->generateToken();
		$pass_is_same = Hash::check($r->old_password, $r->user()->password);
		if(!$pass_is_same){
			return response([
				'errors' => [
					'old_password' => [
						'Password Lama tidak sesuai'
					]
				]
			], 422);
		}
		$r->user()->update([
			'token_number' => $token,
			'password' => bcrypt($r->password),
			'verification_url' => url('/user-verification/'.md5(str_random(20))),
			'last_time_to_verify' => date('Y-m-d H:i:s', strtotime('+2 hours')),
			'status'=>'0'
		]);

		$user = $r->user();
		if(app()->environment() != 'local'){
			event(new SendLinkAndSms('update_password',$user));
		}

		$r->user()->activities()->create([
			'title'		=> 'Profil',
			'content'	=> 'Memperbarui password',
		]);
		Auth::logout();
		return 'Password berhasil diperbarui';
	}

	public function editEmail(Request $r)
	{
		return view('user_profile.edit_email', $this->useroper($r));
	}

	public function updateEmail(UpdateEmail $r)
	{
		$token = $this->generateToken();
		$r->user()->update([
			'token_number' => $token,
			'verification_url' => url('/user-verification/'.md5(str_random(20))),
			'last_time_to_verify' => date('Y-m-d H:i:s', strtotime('+2 hours')),
			'email' => $r->email,
			'status' => '0',
		]);
		$user = $r->user();
		$phone = $r->user()->phone_number;
		if(app()->environment() != 'local'){
			event(new SendLinkAndSms('update_email',$user));
		}

		$r->user()->activities()->create([
			'title'		=> 'Profil',
			'content'	=> 'Memperbarui Email',
		]);
		Auth::logout();
		return 'Email berhasil diubah. Tautan verifikasi sudah dikirim ke '.$r->email.' dan token ke '.$phone.' untuk verifikasi ulang';
	}

	public function updateBank(UpdateUserBank $r)
	{
		$r->user()->bank()->update([
			'status' => '0'
		]);
		$r->user()->activities()->create([
			'title'		=> 'Profil',
			'content'	=> 'Memperbarui rekening',
		]);
		$r->user()->bank()->create($r->only(['on_name', 'bill_number','bank','branch','city'])+['status'=>'1']);
		return 'Rekening berhasil diperbarui';
	}

	public function updateBio(UpdateUserBio $r)
	{
		$r->user()->bio()->update([
			'status' => '0'
		]);
		$data = [
			'nin_upload' 	=> $r->user()->bio()->first() ? $r->user()->bio()->first()->nin_upload : null,
			'photo'			=> $r->user()->bio()->first() ? $r->user()->bio()->first()->photo : null,
		];
		if($r->file('nin_upload')){
			$data['nin_upload'] = str_replace('public/', '', $r->file('nin_upload')->store('public/nin-upload'));
		}
		if($r->file('photo')){
			$data['photo'] = str_replace('public/', '', $r->file('photo')->store('public/photo'));
		}
		$r->user()->bio()->create($r->only(['nin','name','city_born','birthdate','gender','address','province_id','city_id','region_id','village_id','post_code','married',])+['status'=>'1']+$data);

		$r->user()->activities()->create([
			'title'		=> 'Profil',
			'content'	=> 'Memperbarui data diri',
		]);
		return 'Data diri berhasil diperbarui';
	}

	public function updateBiodata(UpdateUserBiodata $r)
	{
		$others = ['skill','passion','hobby','language','character',];
		$r->user()->biodata()->update([
			'status' => '0'
		]);
		foreach($others as $o){
			foreach($r->$o as $d){
				Other::updateOrCreate([
					'name' => trim($d),
					'category' => trim($o)
				]);
			}
		}
		$r->user()->biodata()->create([
			'skill' => implode(',', $r->skill),
			'passion' => implode(',', $r->passion),
			'hobby' => implode(',', $r->hobby),
			'language' => implode(',', $r->language),
			'character' => implode(',', $r->character),
			'status' => '1'
		]);

		$r->user()->activities()->create([
			'title'		=> 'Profil',
			'content'	=> 'Memperbarui biodata',
		]);
		return 'Biodata berhasil diperbarui';
	}

	public function updateBiography($bio, Request $r)
	{
		$r->validate([
			'content' => 'required'
		]);
		$data = $r->user()->biography()->where('status', '1')->first();
		$sd = [
			'status' => '1',
			$bio => $r->content
		];
		if($data){
			$sd+= collect($data->toArray())->except(['id'])->toArray();
		}
		$r->user()->biography()->update([
			'status' => '0'
		]);
		$r->user()->biography()->create($sd);
		$modul = '';
		if($bio == 'social_media'){
			$modul = 'media sosial';
		}elseif($bio == 'contact'){
			$modul = 'kontak';
		}elseif($bio == 'education'){
			$modul = 'pendidikan';
		}elseif($bio == 'work_experience'){
			$modul = 'pengalaman kerja';
		}elseif($bio == 'certificate'){
			$modul = 'sertifikat';
		}elseif($bio == 'appreciation'){
			$modul = 'penghargaan';
		}elseif($bio == 'organization'){
			$modul = 'organisasi';
		}elseif($bio == 'portfolio'){
			$modul = 'portofolio';
		}
		$r->user()->activities()->create([
			'title'		=> 'Profil',
			'content'	=> 'Memperbarui '.$modul.' pada biografi',
		]);
		return $r->name.' berhasil diperbarui';
	}

	public function updateAvatar(Request $r)
	{
		$r->validate([
			'avatar' => 'required|file|mimes:png,jpeg',
		]);
		$avatar = str_replace('public/', '', $r->file('avatar')->store('public/avatars'));
		$user = $r->user();
		$user->update([
			'avatar' => $avatar
		]);

		$r->user()->activities()->create([
			'title'		=> 'Profil',
			'content'	=> 'Memperbarui avatar',
		]);
		return 'Avatar berhasil diperbarui';
	}

	public function printCV(Request $r)
	{

		$r->user()->activities()->create([
			'title'		=> 'Profil',
			'content'	=> 'Mencetak CV',
		]);
		$o = $this->oper($r);
		if($o['user'] && $o['biodata'] && $o['biography'] && $o['my_bio'])
			return view('user_profile.cv_print', $o);
		abort(404);
	}

	public function upgradeForm(Request $r)
	{
		if($r->user()->is_premium){
			return redirect()->route('member_status');
		}
		$oper = [
			'up_member' => Setting::upMember()
		];
		return view('upgrade_member.index', $oper);
	}

	public function upgrade(Request $r)
	{
		$u = $r->user();
		$sisa = $u->balance - $r->cost;
		if($sisa < 0){
			return response([
				'errors' => [
					'deposit' => [
						'Saldo tidak mencukupi'
					]
				]
			], 422);
		}
		$periode = 1;
		if($r->periode === 'three')
			$periode = 3;
		if($r->periode === 'six')
			$periode = 6;
		if($r->periode === 'twelve')
			$periode = 12;
		$u->balance      -= $r->cost;
		$u->is_premium    = '1';
		$until 			  = date('Y-m-d H:i:s', strtotime('+'.$periode.' months'));
		$u->premium_until = $until;
		$u->save();
		$u->premiumLogs()->create([
			'periode' 	=> $periode,
			'until' 	=> $until,
			'cost' 		=> $r->cost,
		]);

		$u->activities()->generate('Upgrade Member', 'Melakukan upgrade member ke premium selama '.$periode.' bulan', Auth::id());
		return 'Upgrade member berhasil';
	}

	public function memberStatus()
	{
		$oper = [
			'logs' => Auth::user()->premiumLogs()->paginate(10),
		];
		return view('member_status.index', $oper);
	}

	public function getUserAktif(Request $r)
	{
		if($r->query('with')){
			return User::with($r->query('with'))->where('id', $r->user()->id)->first();
		}
		return Auth::user();
	}
}
