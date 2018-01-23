<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
}
