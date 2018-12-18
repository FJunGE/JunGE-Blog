<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\UserLogin;
use Auth;
use Event;
use Log;

class SessionController extends Controller
{
    public function __construct(){
        /*只允许未登录的用户訪問的操作*/
        $this->middleware('guest', [
            //未登录用户可以访问 用户登录界面
            'only' => ['create']
        ]);
    }

    public function create(){
        return view('session.create');
    }

    /** 登录 */
    public function store(Request $request){
        $credentials = $this->validate($request, [
           'email' => 'required|email|max:255',
           'password'=> 'required'
        ]);

//        dd($credentials);
        if(Auth::attempt($credentials, $request->has('remember'))){
            //laravel底层来判断该邮箱和密码是否正确一致
            if(Auth::user()->activated){

                //已经使用邮件激活的用户
                event(new UserLogin($credentials));//自定义事件
                session()->flash('success','登录成功');
                return redirect()->intended(route('users.show', [Auth::user()]));
            }else{

                //未激活的用户，但是视图想登录进来
                session()->flash('warning', '滚去验证再来，好吗');
                return redirect('/');
            }

        }else{
            //账户密码不一致的情况下 给出的提示
            session()->flash('danger','很抱歉，您的邮箱和密码不匹配');
            return redirect()->route('login');
        }
    }

    /** 登出 */
    public function destroy(){
        Auth::logout();
        session()->flash('success', '成功退出');
        return redirect()->route('login');
    }
}
