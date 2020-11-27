<?php

use App\Attributes;
use Illuminate\Database\Seeder;

class AttributesTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		$attributes = [
			'labelAttr' => "text",
			'name' => "text",
			'value' => "text",
			'guide' => "text",
			'id_attr' => "text",
			'required' => "checkbox",
			'placeholder' => "text",
			'min' => "text",
			'max' => "text",
			'step' => "text",
			'size' => "text",
			'autocomplete' => "checkbox",
			'is_confirm' => "checkbox",
			'multiple' => "checkbox",
			'accept' => "text",
			'maxlength' => "text",
		];

		foreach ($attributes as $attribute => $type) {

			Attributes::create([
				'attribute' => $attribute,
				'type' => $type,
			]);

		}

	}
}
