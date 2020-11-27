<?php

use Illuminate\Database\Seeder;

class ListingsSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		$listings = [
			'Cream Caramel',
			'Chocolate Cheese Cake',
			'Cupcake',
			'Cream Dessert',
			'Donats',
			'Tulumba',
			'Waffer',
			'Knafeh with cream',
			'Knafeh with nuts',
			'cheese fatayer',
			'Feteer Meshaltet',
			'Fatayer dough',
			'Potato sandwich',
			'Potato starters',
			'Pasta with meat',
			'Hawawshi',
			'Hamburger',
			'Gambary',
			'Shawarma',
			'Pasta with white sauce',
			'Salad',
			'pancake',
			'Noodles',
			'Chicken Grill',
			'Rice and chicken',
		];

		foreach ($listings as $listing) {

			App\Listing::create([
				'name' => $listing,
				'description' => $listing,
				'category_id' => App\Category::inRandomOrder()->first()->id,
				'main_photo' => 'listings/' . str_replace(' ', '_', strtolower($listing)) . '.jpg',
				'price' => random_int(10, 200),
				'supplier_id' => App\Supplier::inRandomOrder()->first()->id,
				'status' => 'active',
			]);

		}

	}

}
