<?php

use App\Category;
use Illuminate\Database\Seeder;

class Categories extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$categories = [
			'Great Meals' => [
				'Sea Food',
				'Appetizers ( Mahashi)',
				'Tajines',
				'Grill Meal (Grilled )',
				'Fattah Meal',
				'El Mhmr',
				'Combo',
			],

			'Fast food' => [
				'Potatoes',
				'Chicken',
				'Hawawshi',
				'Burger',
				'Pizza',
				'Negresco',
				'Nodles',
				'Sausage',
			],

			'Sandwiches' => [
				'Beef sandwich',
				'Chicken sandwich',
				'Hot Dog',
				'Shish Tawook',
				'French fries',
				'Savory Crepe',
			],

			'Desserts' => [
				'Cheese Cake',
				'Pan Cake',
				'Molten Cake',
				'Pastries',
				'Muhalabiya',
				'Om Ali',
				'Rice Pudding',
				'Sweet Crepes',
				'Waffle',
				'Red velvet',
				'Cinnabon',
				'Brownies',

			],

			'Syrian food' => [
				'Chicken Shawarma',
				'Meat Shawarma',
				'Arabic Shawarma Meals',
				'Fatteh Shawarma Meals',
				'Shawarma pie',
				'Tabouleh',
				'Manakeesh',
			],

			'Pancakes' => [
				'Feteer Meshaltet',
				'Pies with cheese and honey',
				'Small pies with cheese and olives',
				'Samosa',
				'Small pizza',
				'Spinach pies',
				'Donut',
			],

		];

		foreach ($categories as $name => $sub_categories) {
			$category = Category::create([
				'name' => $name,
				'desc' => $name,
				'photo' => 'categories/' . str_replace(' ', '_', strtolower($name)) . '.jpg',
			]);

			foreach ($sub_categories as $sub_categories) {
				Category::create([
					'name' => $sub_categories,
					'desc' => $sub_categories,
					'parent_id' => $category->id,
				]);
			}
		}

	}

}
