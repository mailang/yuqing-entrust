<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
  //  return view('welcome');
//});

/*web登录调用的路由*/
/*
Auth::routes();
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/home', 'HomeController@index')->name('home');
*/
/*guard为web暂时不使用，域名跳转到后台登录*/
Route::get('/', function () {
    return redirect()->route('admin.login');
});

Route::get('/admin', ['uses'=>'Admin\LoginController@showLoginForm']);
Route::get('/admin/login', ['uses'=>'Admin\LoginController@showLoginForm','as'=>'admin.login']);
Route::post('/admin/login',['uses'=>'Admin\LoginController@login']);
Route::get('/admin/logout', ['uses'=>'Admin\LoginController@logout','as'=>'admin.logout']);

/*test*/
Route::get('/test', ['uses'=>'TestController@index','as'=>'test']);

Route::group(['prefix' => 'admin', 'namespace' => 'Admin','middleware'=>['admin:admin','menu']], function () {
     include base_path('routes/admin.php');
});

