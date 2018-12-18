<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Mail;
use App\Mail\ConifrmEmail;
class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',[
            //except中间件，除了里面的方法不用登陆外，其它所有的均要登录授权
            'except' => ['show', 'create', 'store', 'index', 'confirmEmail'],
        ]);
    }

    /** 初始化加载的方法*/


    /** 显示用户列表 */
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    /** 刪除用戶*/
    public function destroy(User $user){
        $this->authorize('adminDestroy', $user);
        $user->delete();
        return back();
    }

    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        /** 显示用户博客数*/
        $statuses = $user->statuses()->orderBy('created_at','desc')->paginate('20');
        return view('users.show', compact('user','statuses'));
    }

    /** 注册实例*/
    public function store(Request $request){
        $this->validate($request,[
            'name'  =>  'required|max:50',
            'email' =>  'required|email|unique:users|max:255',
            'passwords'=>    'required|confirmed|min:6'
        ]);

        $user = User::create([
           'name' => $request->name,
           'email' => $request->email,
           'passwords' => bcrypt($request->password)
        ]);

        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '请前往邮箱'.$user->email.'进行激活认证');
        return redirect('/');
    }

    public function edit(User $user){
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }


    /** 编辑个人用户实例 */
    public function update(User $user,Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'passwords' => 'nullable|confirmed|min:6'
        ]);

        //快速授权一个指定行为，$user 对应传参 update 授权方法的第二个参数
        $this->authorize('update', $user);

        $data = array();
        $data['name'] = $request->name;
        if($request->password){
            $data['passwords'] = $request->password;
        }

        $user->update([
            'name' => $request->name,
            'passwords' => bcrypt($request->password)
        ]);

        session()->flash('success','修改成功');
        return redirect()->route('users.show',[$user]);
    }

    /** 发送邮件方法*/
    public function sendEmailConfirmationTo($user){
        $email = $user->email;
        $subject = "感谢注册 Laravel JunGE 应用！请确认你的邮箱。";
        Mail::to($email)->send(new ConifrmEmail($user, $subject));
    }

    /** 用户点击激活链接调整的方法*/
    public function confirmEmail($token){
        $user = User::where('activation_token', $token)->firstOrFail();
        $user->email_verified_at = date('Y-m-d H:i:s',time());
        $user->activation_token = null;
        $user->activated = true;
        $user->save();

        Auth::login($user);
        session()->flash("success", "激活成功");
        return redirect()->route('users.show', [$user]);
    }

    public function follower(User $user){
        dd($user->followers);
        $this->authorize('follow',$user);
        if(! Auth::user()->isFollow($user->id)){
            Auth::user()->follow($user->id);
        }

        return redirect()->route('user.show',$user->id);
    }

    public function unFollower(User $user){
        $this->authorize('follow',$user);
        if(Auth::user()->isFollow($user->id)){
            Auth::user()->unFollow($user->id);
        }

        return redirect()->route('users.show',$user->id);
    }
}
