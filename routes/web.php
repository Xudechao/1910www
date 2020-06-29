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

Route::get('/', function () {
    //echo "WWW";
    return view('welcome');
});

Route::get('/info',function(){
				phpinfo();
});

//你好
Route::get('/test/hello','TestController@hello');
Route::get('/test/redis1','TestController@redis1');
Route::get('/test/sign1','TestController@sign1');
Route::get('/secret','TestController@secret');
Route::get('/test/www','TestController@www');
Route::get('/test/send-data','TestController@sendDate');
Route::post('/test/post-data','TestController@postData');


//商品
Route::get('/goods/detail','Goods\GoodsController@detail');  // 商品详情
//Route::get('/api/goods/info','Goods\GoodsController@goodsInfo');

//Route::get('/api/user/reg','User\UserController@reg');

Route::get('/user/reg','User\IndexController@reg'); // 前台注册
Route::post('/user/regDo','User\IndexController@regDo'); // 后台注册
Route::get('/user/login','User\IndexController@login'); // 前台登录
Route::post('/user/loginDo','User\IndexController@loginDo'); // 后台登录

Route::get('/user/center','User\IndexController@center'); // 用户

//API
Route::post('/api/user/reg','Api\UserController@reg'); // 注册
Route::post('/api/user/login','Api\UserController@login');  //登录
Route::get('/api/user/center','Api\UserController@center')->middleware('check.pri');;      //个人中心
Route::get('/api/my/orders','Api\UserController@orders')->middleware('check.pri');      //我的订单
Route::get('/api/my/cart','Api\UserController@cart')->middleware('check.pri');      //我的购物车

Route::get('/api/a','Api\TestController@a')->middleware('check.pri','access.filter');
Route::get('/api/b','Api\TestController@b')->middleware('check.pri','access.filter');
Route::get('/api/c','Api\TestController@c')->middleware('check.pri','access.filter');

Route::middleware('check.pri','access.filter')->group(function(){
    Route::get('/api/x','Api\TestController@x');
    Route::get('/api/y','Api\TestController@y');
    Route::get('/api/z','Api\TestController@z');
});
