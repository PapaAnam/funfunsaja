<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerifyAccount;
use App\Http\Requests\Register;
use Illuminate\Http\Request;
use App\Events\UserCreated;
use App\Notification;
use App\User;
use Auth;
use Hash;
use App\Activity;
// use Route;

class AutentikasiController extends Controller
{

	private function last_time_to_verify()
	{
		return date('Y-m-d H:i:s', strtotime('+2 hours'));
	}

	private function setLoginAct()
	{
		Auth::user()->activities()->create([
			'title'		=> 'Masuk',
			'content'	=> 'Masuk pada website',
		]);
	}

	private function generateVerifURL()
	{
		return url('/user-verification/'.md5(str_random(20)));
	}

	private function generateToken()
	{
		return str_random(3).array_random(range(0,9)).array_random(range(0,9)).str_random(2).array_random(['$', '#', '*', '%', '&', '@']).str_random(2);
	}

	public function register(Register $r)
	{
		$token = $this->generateToken();
		$user = new User();
		$user->email       			= $r->email ;
		$user->password    			= bcrypt($token);
		$user->phone_number 		= $r->phone_number ;
		$user->token_number 		= $token;
		$user->verification_url 	= $this->generateVerifURL();
		$user->last_time_to_verify 	= $this->last_time_to_verify();
		$user->wrong_login 			= '0';
		$user->status      			= '0';
		$user->avatar 				= 'path/to/avatar';
		$user->balance 				= 0;
		$user->point 				= 0; 
		$user->save();
		if(app()->environment() != 'local')
			event(new UserCreated($user));
		Activity::create([
			'title'		=> 'Daftar',
			'content'	=> 'Melakukan pendaftaran',
			'user_id'	=> $user->id,
		]);
		return 'Daftar berhasil dilakukan, silahkan cek email dan sms untuk proses verifikasi';
	}

	public function login(Request $r)
	{
		$redirect = explode('redirect', url()->previous());
		$redirect = ltrim(end($redirect), '=');
		$usr = User::where('email', $r->email)->first();
		$exist = $usr && Hash::check($r->password, $usr->password);
		if($exist){
			$existAndActive = $usr->status == '1';
			if($existAndActive){
				if(Auth::guard()->attempt([
					'email' => $r->email,
					'password' => $r->password
				], true)){
					$ress=array(
						'wrong_login' 	=> '0',
						'last_login'	=> now(),
						'must_logout'	=> date('Y-m-d H:i:s', strtotime('+'.config('app.lifetime', 1).' days'))
					);
					User::where('email', $r->email)->update($ress);
					session([
						'auth' => 'ok'
					]);
					Auth::guard('admin')->logout();
					$this->setLoginAct();
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
				User::where('email', $r->email)->activities()->create([
					'title'		=> 'Salah Password',
					'content'	=> 'Salah memasukkan password'
				]);
				return response([
					'message' 	=> 'password salah',
					'sisa' 		=> 2-$user->wrong_login
				], 419);
			}
		}
	}

	public function checkEmail(Request $r)
	{
		$r->validate([
			'email' => 'required|email'
		]);
		if(User::where('email', $r->email)->count()){
			if(User::where('email', $r->email)->where('status', '1')->count()){
				return 1;
			}else if(User::where('email', $r->email)->where('status', '2')->count()){
				return response([
					'status' => 'banned',
					'message' => 'akun anda dibanned'
				], 419);
			}
			return response([
				'status' => 'non_active',
				'message' => 'akun anda non aktif'
			], 419);
		}
		return response([
			'status' => 'not_found',
			'message' => 'email belum terdaftar'
		], 419);
	}

	public function checkEmail2(Request $r)
	{
		$r->validate([
			'email' => 'required|email'
		], [
			'email' => 'email tidak valid'
		]);
		if(User::where('email', $r->email)->count()){
			return response(1, 419);
		}
		return 0;
	}

	public function checkEmail3(Request $r)
	{
		$r->validate([
			'email' => 'required|email|exists:users'
		], [
			'email' => 'email tidak valid'
		]);
		return 1;
	}

	public function checkNoHp(Request $r)
	{
		$r->validate([
			'phone_number' => 'required|numeric|min:10000'
		], [
			'phone_number.numeric' => 'no hp hanya boleh angka',
			'phone_number.required' => 'no hp tidak boleh kosong',
			'phone_number.min' => 'no hp tidak valid',
		]);
		if(User::where('phone_number', $r->phone_number)->count()){
			return response(1, 419);
		}
		return 0;
	}

	public function checkNoHp2(Request $r)
	{
		$r->validate([
			'phone_number' => 'required|numeric|min:10000'
		], [
			'phone_number.numeric' => 'no hp hanya boleh angka',
			'phone_number.required' => 'no hp tidak boleh kosong',
			'phone_number.min' => 'no hp tidak valid',
		]);
		$user = User::where('email', $r->email)->first();
		$nc = $user->phone_number != $r->phone_number;
		if($nc)
			$r->validate([
				'phone_number' => 'unique:users'
			]);
		if($nc){
			return [
				'status' => 1,
				'msg' => 'No HP akan diperbarui dengan ini'
			];
		}
		return [
			'status' => 1,
			'msg' => 'No HP valid'
		];
	}

	public function logout(Request $r)
	{
		$r->user()->activities()->create([
			'title'		=> 'Keluar',
			'content'	=> 'Keluar dari website'
		]);
		Auth::logout();
		if($r->ajax)
			return response('Anda berhasil keluar');
		return redirect('/');
	}

	public function verifyForm($id)
	{
		$exist = User::where('verification_url', url('user-verification/'.$id))->count();
		if($exist){
			$user = User::where('verification_url', url('user-verification/'.$id))->first();
			if($user->last_time_to_verify < now())
				return view('verify_expired');
			return view('verify_form', ['url'=>$id]);
		}else{
			return abort(404);
		}
	}

	public function verify($url, VerifyAccount $r)
	{
		$exist = User::where('verification_url', url('user-verification/'.$url))->count();
		if($exist){
			$user = User::where('verification_url', url('user-verification/'.$url))->first();
			if($user->last_time_to_verify < now())
				return response('Tautan verifikasi sudah kadaluwarsa', 409);
			if($user->token_number != $r->token)
				return response('Token yang anda masukkan salah', 409);
			if(Auth::loginUsingId($user->id, true)){
				User::where('verification_url', url('user-verification/'.$url))->update([
					'verification_url' 		=> null,
					'status' 				=> '1',
					'last_time_to_verify' 	=> null,
					'must_logout'			=> date('Y-m-d H:i:s', strtotime('+'.config('app.lifetime', 1).' days')),
					'wrong_login' 			=> 0,
					'last_login'			=> now(),
				]);
				session([
					'auth' => 'ok'
				]);
				Auth::guard('admin')->logout();
				$this->setLoginAct();
				Auth::user()->activities()->create([
					'title'		=> 'Verifikasi Berhasil',
					'content'	=> 'Melakukan verifikasi',
				]);
				return 'Selamat, akun anda sudah aktif';
			}
			return response('gagal', 500);
		}else{
			return abort(404);
		}
	}

	public function sendVerif(Request $r)
	{
		$token = $this->generateToken();
		$user = User::where('email', $r->email);
		$user->update([
			'token_number' 			=> $token,
			'verification_url' 		=> $this->generateVerifURL(),
			'last_time_to_verify' 	=> $this->last_time_to_verify(),
			'password' 				=> bcrypt($token),
			'phone_number' 			=> $r->phone_number,
			'status' 				=> '0'
		]);
		$user = User::where('email', $r->email)->first();
		Activity::create([
			'title'		=> 'Verifikasi',
			'content'	=> 'Mengirim link verifikasi',
			'user_id'	=> $user->id,
		]);
		if(app()->environment() != 'local')
			event(new UserCreated($user));	
		return 'Tautan verifikasi sudah dikirim ke '.$r->email.'. Cek juga SMS yang masuk ke '.$r->phone_number.' untuk memasukkan token';
	}

	public function forgotPassword(Request $r)
	{
		$token = $this->generateToken();
		$user = User::where('email', $r->email);
		$user->update([
			'token_number' 			=> $token,
			'verification_url' 		=> $this->generateVerifURL(),
			'last_time_to_verify' 	=> $this->last_time_to_verify(),
			'password' 				=> bcrypt($token),
			'status' 				=> '0'
		]);
		$user = User::where('email', $r->email)->first();
		Activity::create([
			'title'		=> 'Lupa Password',
			'content'	=> 'Mereset password',
			'user_id'	=> $user->id,
		]);
		Notification::create([
			'title'		=> 'Lupa Password',
			'content'	=> 'Password berhasil direset',
			'to_id'		=> $user->id,
			'type'		=> 'success'
		]);
		if(app()->environment() != 'local')
			event(new UserCreated($user));	
		return 'Kata sandi berhasil direset. Tautan verifikasi ulang sudah dikirim ke '.$r->email.'. Cek juga SMS yang masuk ke '.$user->phone_number.' untuk memasukkan token';
	}

	public function loginForm()
	{
		if(Auth::check())
			return redirect('/');
			return view('user_auth.login');
		}
	}
