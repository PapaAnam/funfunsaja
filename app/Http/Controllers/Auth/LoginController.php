<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use Validator;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin-menu';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        if(Auth::check()){
            abort(404);
        }
        return view('auth.login');
    }

    public function username()
    {
        return 'username';
    }

    public function guard()
    {
        return Auth::guard('admin');
    }

    public function login(Request $r)
    {
        $validator = Validator::make($r->all(),[]);
        if(Admin::where('username', $r->username)->count()){
            $this->validateLogin($r);
            if ($this->hasTooManyLoginAttempts($r)) {
                $this->fireLockoutEvent($r);
                return $this->sendLockoutResponse($r);
            }

            if ($this->attemptLogin($r)) {
                Auth::logout();
                Auth::guard('admin')->user()->activities()->create([
                    'title'     => 'Masuk',
                    'content'   => 'Masuk pada website',
                    'user_type' => '1'
                ]);
                Auth::guard('admin')->user()->update([
                    'must_logout'   => date('Y-m-d H:i:s', strtotime('+'.config('app.lifetime', 1).' days')),
                    'aktivitas_terakhir'=>date('Y-m-d H:i:s'),
                ]);
                return $this->sendLoginResponse($r);
            }
            $this->incrementLoginAttempts($r);
            $validator->after(function($v){
                $v->errors()->add('password', 'password salah');
            });
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $validator->after(function($v){
            $v->errors()->add('username', 'username tidak ada');
        });
        return redirect()->back()->withErrors($validator)->withInput();
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), true
        );
    }

    public function logout(Request $r)
    {
        $this->guard()->user()->activities()->create([
            'title'     => 'Keluar',
            'content'   => 'Keluar dari website',
            'user_type' => '1'
        ]);
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }
}
