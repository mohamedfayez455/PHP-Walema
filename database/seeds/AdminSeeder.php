<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\App\Admin::create(['email' => 'admin@admin.com', 'password' => bcrypt('admin'), 'firstname' => 'admin', 'lastname' => 'admin']);
	}
}
