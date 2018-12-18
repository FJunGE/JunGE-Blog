<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

//模型工程 生成假数据进行赋值 但未填充
$factory->define(App\Models\User::class, function (Faker $faker) {
    $date_time = $faker->date . ' ' . $faker->time;
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'passwords' => empty($password) ? bcrypt('huan0579') : $password, // secret
        'remember_token' => str_random(10),
        'is_admin' => false,
        'activated' => true,
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});
