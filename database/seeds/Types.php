<?php

use App\Type;
use Illuminate\Database\Seeder;

class Types extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$types = ['Head Chef', 'Executive Chef', 'Sous Chef', 'Station Chef', 'Expediter', 'Kitchen Manager', 'Pastry Chef', 'Saucier', 'Poissonier', 'Pantry Chef', 'Rotisseur', 'Entremetier', 'Commis Chef',
		];

		foreach ($types as $type) {
			Type::create([
				'name' => $type,
				'slug' => str_slug($type),
				'desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed eiusmod tempor incididunt labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo....',
			]);
		}
	}
}
