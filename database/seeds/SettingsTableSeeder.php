<?php

use App\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Setting::create([
			'app_name' => 'Walema',
			'icon' => 'settings/icon.jpeg',
			'email' => 'info@walema.com',
			'description' => 'motivated by the rapid advance in technology,
customers culture engagement to this technology,
and taking advantage of everything that is new and easy by using smartphones and labs,
we established a new service called"walema" that  provied Easier and faster home delivery of home food ',
			'status' => 'open',
			'message_maintenance' => '',
		]);
	}
}
