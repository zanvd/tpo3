<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */
$factory->define(App\Models\Uporabnik::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('123456'),
        'vloga' => $faker->word
    ];
});
