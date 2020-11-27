<?php

use Illuminate\Database\Seeder;

class AdvancedSearchSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::table('advanced_search')->insert([

			'search_with_category' => 'on',
			'search_with_sub_category' => 'on',
			'search_with_type' => 'on',
		]);
	}
}
