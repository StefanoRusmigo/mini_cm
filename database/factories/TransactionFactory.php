<?php

use Faker\Generator as Faker;

$factory->define(App\Transaction::class, function (Faker $faker) {
    return [
        'amount'=>$faker->randomFloat(2,10,100000),
        'transaction_date'=>$faker->dateTime()
    ];
});

