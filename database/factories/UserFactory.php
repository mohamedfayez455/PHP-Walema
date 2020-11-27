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

$factory->define(App\Customer::class, function (Faker $faker) {

	$name = $faker->name;
	$firstname = substr($name, 0, strlen($name) / 2);
	$lastname = substr($name, strlen($name) / 2);

	return [
		'firstname' => $firstname,
		'lastname' => $lastname,
		'email' => $faker->unique()->safeEmail,
		'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
		'remember_token' => str_random(10),
	];
});

$factory->define(App\Supplier::class, function (Faker $faker) {

	$name = $faker->name;
	$firstname = substr($name, 0, strlen($name) / 2);
	$lastname = substr($name, strlen($name) / 2);

	return [
		'firstname' => $firstname,
		'lastname' => $lastname,
		'email' => $faker->unique()->safeEmail,
		'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
		'remember_token' => str_random(10),
	];
});

$factory->define(App\Listing::class, function (Faker $faker) {

	return [
		'name' => $faker->name,
		'description' => str_random(50),
		'category_id' => App\Category::inRandomOrder()->first()->id,
		'main_photo' => 'listings/default.png', // secret
		'price' => random_int(10, 200),
		'supplier_id' => App\Supplier::inRandomOrder()->first()->id,
		'status' => 'active',
	];
});