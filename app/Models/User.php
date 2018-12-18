<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;

class User extends Authenticatable
{
    use Notifiable;

    public $rate_limit = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function statuses()
    {
        return $this->hasOne(Status::class);
    }

    /** gravatar头像合成 */
    public function gravatar($s = 140, $d = 'robohash'){
        $url = "https://www.gravatar.com/avatar/";
        $url .= md5(strtolower(trim($this->attributes['email'])));
        $url .= "?s=$s&d=$d";
        return $url;
    }

    public static function boot(){
        parent::boot();

        static::creating(function ($user) {
            $user->activation_token = str_random(30);
        });
    }

    //邮件消息事件
    public function sendPasswordResetNotification($token){
        $this->notify(new ResetPassword($token));
    }

    //获取当前博主的粉丝 关联的外键是user_id,也就是当前user_id下的follower_id
    public function followers(){
        return $this->belongsToMany(User::class,'followers','user_id','follower_id');
    }

    //获取当前粉丝的博主 关联的外键是follower_id,也就是找出当前follower_id下的user_id
    public function followings(){
        return $this->belongsToMany(User::class,'followers','follower_id','user_id');
    }

    //关注
    public function follow($user_ids){
        if(!is_array($user_ids)){
            $user_ids = compact('user_ids');
        }
        //给当前粉丝设置博主id，换言之也就是关注
        $this->followings()->sync($user_ids,false);
    }

    //取消关注
    public function unFollow($user_ids){
        if(!is_array($user_ids)){
            $user_ids = compact('user_ids');
        }
        //删除当前用户中所关联的user_ids，也就是取消关注
        $this->followings()->detach($user_ids);
    }

    //是否已经关注了
    public function isFollow($user_ids){
        return $this->followings->contains($user_ids);
    }
}
