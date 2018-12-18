<?php

use Illuminate\Database\Seeder;
use App\Models\User;
class UsersTableSeeder extends Seeder
{
    /**
     * 数据填充
     * Run the database seeds.
     *
     * @return void
     *
     */
    public function run()
    {
        //factory选择模型工厂 times填充的次数 make生成一个集合
        $user = factory(User::class)->times(500)->make();//创建一个集合
        //makeVisible临时显示隐藏属性$hidden
        User::insert($user->makeVisible(['password','remember_token'])->toArray());

        //对第一条数据进行重新修改
        $user = User::first();
        $user->name = 'JunGE';
        $user->email = 'juncr.feng@gmail.com';
        $user->passwords = bcrypt('huan0579');
        $user->is_admin = true;
        $user->activated = true;
        $user->save();
    }
}
