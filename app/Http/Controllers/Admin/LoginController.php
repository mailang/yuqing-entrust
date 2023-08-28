<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Hashing\BcryptHasher as Hasher;

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
    protected $redirectTo = '/admin/index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //默认的guard是web,这里调用的guard为admin;
       //$this->middleware('guest')->except('logout');
        $this->middleware('guest:admin', ['except' => 'logout']);
    }
    /**
     * 修改登录认证
     * 默认是使用email认证
     */
    public function username()
    {
        return 'username';
     }

    /**登录页面进行重新重写
     *
     */
    public function showLoginForm()
    {
        return view('login');
    }

     /* 自定义认证驱动
     * @return mixed
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
    /*
     * 退出
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('admin/');
    }

     /**
     * DESC: 重写 AuthenticatesUsers 登录验证方法，并自定义提示信息;
     * 原验证方法 Illuminate\Foundation\Auth\AuthenticatesUsers
     * @param Request $request
     */ 
    protected function validateLogin(Request $request){
        
        //$value = $request

        // $key = $request->session()->get('captcha.key');
        // $key = Crypt::decrypt($key);


        // dd($key);
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
            'captcha' => 'required|captcha',
        ],[
            'captcha.required' => '请填写验证码',
            'captcha.captcha' => '验证码错误',
        ]);
    }

}
