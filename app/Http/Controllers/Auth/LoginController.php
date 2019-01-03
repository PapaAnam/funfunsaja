<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use Validator;
use Auth;
use Hash;

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

    public function login(Request $request)
    {
        $admin = null;
        $request->validate([
            'username'=>[
                'required',
                function($attribute, $value, $fail) use (&$admin, $request){
                    $admin = Admin::where('username', $request->username)->first();
                    if (is_null($admin)) {
                        return $fail('User tidak ada.');
                    }
                },
            ],
            'password'=>[
                'required',
                function($attribute, $value, $fail) use (&$admin, $request){
                    if (!is_null($admin)) {
                        if(!Hash::check($request->password, $admin->password)){
                            return $fail('Password salah.');
                        }
                    }
                },
            ]
        ]);
        Auth::guard('admin')->login($admin);
        Auth::guard('admin')->user()->activities()->create([
            'title'     => 'Masuk',
            'content'   => 'Masuk pada website',
            'user_type' => '1'
        ]);
        Auth::guard('admin')->user()->update([
            'must_logout'           => date('Y-m-d H:i:s', strtotime('+'.config('app.lifetime', 1).' days')),
            'aktivitas_terakhir'    => date('Y-m-d H:i:s'),
            'api_token'             => bcrypt(date('Ymd').$admin->username.str_random())
        ]);
        // return Auth::guard('admin')->user();
        return redirect('admin-menu');
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

    protected function authenticated(Request $request, $user)
    {
        dd($user);
    }
}
