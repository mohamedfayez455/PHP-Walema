<?php

use App\Supplier;
use App\User;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		Supplier::create(['user_id' => 1]);
		Supplier::create(['user_id' => 2]);

		$faker = Faker\Factory::create();
		for ($i = 0; $i < 50; $i++) {

			$name = substr($faker->name, 0, 20);
			$firstname = substr($name, 0);
			$lastname = substr($name, strlen($name) / 2);

			$user = User::create([

				'firstname' => $firstname,
				'lastname' => $lastname,
				'email' => $faker->unique()->safeEmail,
				'country_id' => random_int(1, 245),
				'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
				'remember_token' => str_random(10),
				'role' => 'supplier',

			]);

			Supplier::create(['user_id' => $user->id]);

		}

	}
}
