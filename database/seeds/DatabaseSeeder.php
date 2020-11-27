<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		$this->call(CountrySeeder::class);
		$this->call(AdminSeeder::class);
		$this->call(UserSeeder::class);
		$this->call(SupplierSeeder::class);
		$this->call(CustomerSeeder::class);

		$this->call(AttributesTableSeeder::class);
		$this->call(InputFieldsTableSeeder::class);

		$this->call(SupplierFormbuilderSeeder::class);
		$this->call(CustomerFormbuilderSeeder::class);
		$this->call(EnquiryFormbuilderSeeder::class);

		$this->call(SettingsTableSeeder::class);
		$this->call(AdvancedSearchSeeder::class);

		$this->call(Types::class);
		$this->call(Categories::class);
		$this->call(ListingsSeeder::class);
	}
}
