<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Status::class, function (Faker $faker) {
    $date_time = $faker->date. ' ' .$faker->time;
    return [
        'title' => $faker->sentence(mt_rand(3,10)),
        'text_content'=> join("\n\n", $faker->paragraphs(mt_rand(3, 6))),
        'created_at'=>$date_time,
        'updated_at'=>$date_time,
    ];
});
