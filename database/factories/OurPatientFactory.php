<?php

$factory->define(App\OurPatient::class, function (Faker\Generator $faker) {
    return [
        "huduma_no" => $faker->name,
        "f_no" => $faker->name,
        "m_no" => $faker->name,
        "l_name" => $faker->name,
        "dob" => $faker->date("Y-m-d H:i:s", $max = 'now'),
        "email" => $faker->safeEmail,
        "telephone" => $faker->name,
        "address" => $faker->name,
        "diagnostic" => $faker->name,
        "prescription" => $faker->name,
    ];
});
