<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Topic::class, function (Faker $faker) {

    $sentence = $faker->sentence();
    //随机获取一个月以内的时间
    $updated_at = $faker->dateTimeThisMonth();
    //传参为生成时间不能超过的时间，创建时间应该比更新时间早！
    $created_at = $faker->dateTimeThisMonth($updated_at);

    return [
        'title' => $sentence,
        'body'  => $faker->text(),
        'excerpt'=> $sentence,
        'created_at'=> $created_at,
        'updated_at'=> $updated_at,
    ];
});
