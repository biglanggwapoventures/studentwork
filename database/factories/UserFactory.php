<?php

use Faker\Generator as Faker;
use App\User;

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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'middle_initial' => strtoupper($faker->randomLetter),
        'username' => $faker->unique()->userName,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'contact_number' => $faker->e164PhoneNumber,
        'birthdate' => $faker->date(),
        'user_role' => $faker->randomElement([User::USER_TYPE_ADVISER, User::USER_TYPE_STUDENT])
    ];
});

$factory->define(App\Area::class, function (Faker $faker) {
    return [
        'name' => ucfirst($faker->unique()->company)
    ];
});
