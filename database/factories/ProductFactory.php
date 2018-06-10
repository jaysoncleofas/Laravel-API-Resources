<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'product_name' => $faker->userName,
        'description' => $faker->text(200)
    ];
});
