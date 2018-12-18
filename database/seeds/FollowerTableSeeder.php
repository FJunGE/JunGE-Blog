<?php

use Illuminate\Database\Seeder;
use App\Models\User;
class FollowerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $user = $users->first();

        $followers = $users->slice(1);
        $follower_ids = $users->pluck('id')->toArray();

        //用户id1关注全部用户
        $user->follow($follower_ids);

        foreach($followers as $follower){
            //除了id1用户都要关注id1用户
            $follower->follow($user->id);
        }
    }
}
