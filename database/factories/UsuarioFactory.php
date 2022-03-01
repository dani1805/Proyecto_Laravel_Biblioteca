<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Usuario;
use Faker\Generator as Faker;

$factory->define(Usuario::class, function (Faker $faker) {
    return [
        
        'nombre' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'contrasenia' => bcrypt('estech')
    ];
});
