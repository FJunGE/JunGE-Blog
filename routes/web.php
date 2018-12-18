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
    return view('welcome');
});


Route::get('/','StaticPagesController@home')->name('home');
Route::get('/about','StaticPagesController@about')->name('about');
Route::get('/help','StaticPagesController@help')->name('help');

/*用户注册*/
//Route::get('/users/{user}', 'UsersController@show');
Route::resource('users', 'UsersController');

/*用户登录*/
Route::get('login', 'SessionController@create')->name('login');
Route::post('login', 'SessionController@store')->name('login.store');
Route::delete('login', 'SessionController@destroy')->name('logout');

/*邮件*/
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');
Route::get('mailable', function (){
    $user = App\Models\User::where(['email'=>'juncr@foxmail.com'])->firstOrFail();
    $subject = "感谢注册 Laravel JunGE 应用！请确认你的邮箱。";
    return new App\Mail\ConifrmEmail($user, $subject);
});

/*密碼重置*/
Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');//显示密码重置页面
Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');//发送链接到邮箱
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');//显示能更新密码页面
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');//更新密码

/*微博路由*/
Route::resource('statuses','StatusesController',['only'=>['store','destroy','show','edit','update']]);

/*用户关注*/
Route::post('users/follower/{user}', 'UsersController@follower')->name('user.follower');
Route::post('users/unfollower/{user}', 'UsersController@unFollower')->name('user.unfollower');

//路由分组
//路由命名前缀 自动给子路由分配路由前缀+路由名称前缀
Route::name('test.')->prefix('test')->group(function (){
    Route::get('posts/{id}', function (){
        return response(Route::currentRouteName());//输出当前路由的名称
    })->name('posts');

    //隐式绑定 将参数传入闭包 对参数进行Eloquent查询 模型中
    Route::get('user/{user}', function (App\Models\User $user){
        return $user->name;//无值输出404
    });
});

//兜底路由 --Laravel 5.6
//所谓兜底路由，就是当路由文件中定义的所有路由都无法匹配用户请求的 URL 时，用来处理用户请求的路由，
//在此之前，Laravel 都会通过异常处理器为这种请求返回 404 响应，
//使用兜底路由的好处是我们可以对这类请求进行统计并进行一些自定义的操作，
//比如重定向，或者一些友好的提示什么的，兜底路由可以通过 Route::fallback 来定义
Route::fallback(function() {
    return "别再TM视图攻击老子的网站";
});

//路由频率限制
//所谓频率限制，指的是在指定时间单个用户对某个路由的访问次数限制，该功能有两个使用场景，
//1、一个是在某些需要验证/认证的页面限制用户失败尝试次数，提高系统的安全性，
//2、另一个是避免非正常用户（比如爬虫）对路由的过度频繁访问，从而提高系统的可用性，
//此外，在流量高峰期还可以借助此功能进行有效的限流。
Route::middleware('throttle:5,1')->prefix('test')->group(function (){
   Route::get('api', function (){
        return "1分钟内只能访问5次，否则报429（请求过于频繁）";
   });
});

//动态设置频率次数的值
//User 模型包含rate_limit属性，则可以将属性名称传递给 throttle 中间件，以便它用于计算最大请求计数：
Route::middleware('throttle:rate_limit,1')->prefix('test')->group(function (){
    Route::get('user/{user}', function ($user){
        return $user . "1分钟内只能访问rate_limit(User Eloquent 属性)次，否则报429（请求过于频繁）";
    });
});