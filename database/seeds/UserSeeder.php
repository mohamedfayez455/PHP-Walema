<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		\App\User::create(['email' => 'supplier@gmail.com', 'password' => bcrypt('supplier'), 'firstname' => 'supplier', 'lastname' => 'supplier', 'verified' => 1, 'approved' => 1, 'role' => 'supplier', 'country_id' => '64']);

		\App\User::create(['email' => 'supplier1@gmail.com', 'password' => bcrypt('supplier1'), 'firstname' => 'supplier1', 'lastname' => 'supplier1', 'verified' => 1, 'approved' => 1, 'role' => 'supplier', 'country_id' => '64']);

		\App\User::create(['email' => 'customer@gmail.com', 'password' => bcrypt('customer'), 'firstname' => 'customer', 'lastname' => 'customer', 'verified' => 1, 'approved' => 1, 'role' => 'customer', 'country_id' => '64']);

		\App\User::create(['email' => 'customer1@gmail.com', 'password' => bcrypt('customer1'), 'firstname' => 'customer1', 'lastname' => 'customer1', 'verified' => 1, 'approved' => 1, 'role' => 'customer', 'country_id' => '64']);

	}
}
