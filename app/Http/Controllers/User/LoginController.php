<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Activity;
use App\User;
use Hash;
use Auth;

class LoginController extends Controller
{
	public function login(Request $r)
	{
		$redirect 	= explode('redirect', url()->previous());
		$redirect 	= ltrim(end($redirect), '=');
		$usr 		= User::where('email', $r->email)->first();
		$exist 		= $usr && Hash::check($r->password, $usr->password);
		if($exist){
			$existAndActive = $usr->status == '1';
			if($existAndActive){
				$sudah30menit = strtotime(date('Y-m-d H:i:s')) - strtotime($usr->aktivitas_terakhir) > 1800;
				if($sudah30menit || is_null($sr->aktivitas_terakhir)){
					User::find($usr->id)->update([
						'logged_in'=>'0'
					]);
				}
				$usr = User::find($usr->id);
				if($usr->logged_in == 1 && strtotime($usr->must_logout) > strtotime(date('Y-m-d H:i:s'))){
					return response('logged_in', 422);
				}
				if(Auth::guard()->attempt([
					'email' => $r->email,
					'password' => $r->password
				], true)){
					$ress=array(
						'wrong_login' 	=> '0',
						'last_login'	=> now(),
						'must_logout'	=> date('Y-m-d H:i:s', strtotime('+'.config('app.lifetime', 1).' days')),
						'logged_in'		=> '1',
						'aktivitas_terakhir'=>date('Y-m-d H:i:s'),
					);
					User::where('email', $r->email)->update($ress);
					session([
						'auth' => 'ok'
					]);
					Auth::guard('admin')->logout();
					Activity::create([
						'title'		=> 'Masuk',
						'content'	=> 'Masuk pada website',
						'user_id'	=> $usr->id,
					]);
					if($redirect)
						return $redirect;
					return url('/');
				}else{
					return response('gagal', 422);
				}
			}else{
				return response([
					'message' => 'non active'
				], 419);
			}
		}else{
			$user = User::where('email', $r->email)->first();
			if($user->wrong_login>='2'){
				User::where('email', $r->email)->update([
					'wrong_login' =>'0',
					'status'      =>'0'
				]);
				return response([
					'message' => 'non active'
				], 419);
			}else{
				User::where('email', $r->email)->update([
					'wrong_login' => $user->wrong_login+1
				]);
				// memasukkan ke dalam riwayat
				Activity::create([
					'title'		=> 'Salah Password',
					'content'	=> 'Salah memasukkan password',
					'user_id'	=> $usr->id,
				]);
				return response([
					'message' 	=> 'password salah',
					'sisa' 		=> 2-$user->wrong_login
				], 419);
			}
		}
	}
}
