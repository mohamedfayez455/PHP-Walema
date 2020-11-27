<?php

use App\InputAttribute;
use App\InputFields;
use Illuminate\Database\Seeder;

class InputFieldsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		$elements = [
			'dropdown' => ['Dropdown Select', ''],
			'select' => ['Select', ''],
			'item' => ['Item', 1],
			'option' => ['Option', 2],
		];

		foreach ($elements as $type => $value) {

			if ($type == "item") {
				break;
			}

			$input = InputFields::create([
				'type' => $type,
				'name' => $value[0],
				'parent_id' => $value[1],
			]);

			for ($x = 1; $x <= 5; $x++) {

				if ($x == 3) {
					continue;
				}

				if ($input->type == "dropdown" and $x == 1) {
					continue;
				}

				InputAttribute::create([
					'input_fields_id' => $input->id,
					'attributes_id' => $x,
				]);

			}

		}

		$input = InputFields::create([
			'type' => 'item',
			'name' => 'Item',
			'parent_id' => 1,
		]);

		$input = InputFields::create([
			'type' => 'option',
			'name' => 'Option',
			'parent_id' => 2,
		]);

		$inputs = [
			'text', 'tel', 'number', 'range',
			'email', 'password', 'radio', 'checkbox',
			'url', 'textarea', "file",
		];

		foreach ($inputs as $values) {

			$input = InputFields::create([
				'type' => $values,
				'name' => ucfirst($values),
				'parent_id' => '',
			]);

			for ($n = 1; $n <= 5; $n++) {

				InputAttribute::create([
					'input_fields_id' => $input->id,
					'attributes_id' => $n,
				]);

			}
		}

		InputAttribute::create([
			'input_fields_id' => 2,
			'attributes_id' => 14,
		]);

		InputAttribute::create([
			'input_fields_id' => 5,
			'attributes_id' => 6,
		]);

		InputAttribute::create([
			'input_fields_id' => 5,
			'attributes_id' => 7,
		]);

		InputAttribute::create([
			'input_fields_id' => 5,
			'attributes_id' => 11,
		]);

		InputAttribute::create([
			'input_fields_id' => 5,
			'attributes_id' => 16,
		]);

		//-----------------------------------------------------

		InputAttribute::create([
			'input_fields_id' => 6,
			'attributes_id' => 6,
		]);

		InputAttribute::create([
			'input_fields_id' => 6,
			'attributes_id' => 7,
		]);

		InputAttribute::create([
			'input_fields_id' => 6,
			'attributes_id' => 11,
		]);

		InputAttribute::create([
			'input_fields_id' => 6,
			'attributes_id' => 16,
		]);

		//-----------------------------------------------------

		InputAttribute::create([
			'input_fields_id' => 7,
			'attributes_id' => 6,
		]);

		InputAttribute::create([
			'input_fields_id' => 7,
			'attributes_id' => 7,
		]);

		InputAttribute::create([
			'input_fields_id' => 7,
			'attributes_id' => 8,
		]);

		InputAttribute::create([
			'input_fields_id' => 7,
			'attributes_id' => 9,
		]);

		//-----------------------------------------------------

		InputAttribute::create([
			'input_fields_id' => 8,
			'attributes_id' => 6,
		]);

		InputAttribute::create([
			'input_fields_id' => 8,
			'attributes_id' => 7,
		]);

		InputAttribute::create([
			'input_fields_id' => 8,
			'attributes_id' => 8,
		]);

		InputAttribute::create([
			'input_fields_id' => 8,
			'attributes_id' => 9,
		]);

		InputAttribute::create([
			'input_fields_id' => 8,
			'attributes_id' => 10,
		]);

		//-----------------------------------------------------

		InputAttribute::create([
			'input_fields_id' => 9,
			'attributes_id' => 6,
		]);

		InputAttribute::create([
			'input_fields_id' => 9,
			'attributes_id' => 7,
		]);

		InputAttribute::create([
			'input_fields_id' => 9,
			'attributes_id' => 16,
		]);

		//-----------------------------------------------------

		InputAttribute::create([
			'input_fields_id' => 10,
			'attributes_id' => 6,
		]);

		InputAttribute::create([
			'input_fields_id' => 10,
			'attributes_id' => 7,
		]);

		InputAttribute::create([
			'input_fields_id' => 10,
			'attributes_id' => 13,
		]);

		//-----------------------------------------------------

		InputAttribute::create([
			'input_fields_id' => 13,
			'attributes_id' => 6,
		]);

		InputAttribute::create([
			'input_fields_id' => 13,
			'attributes_id' => 7,
		]);

		//-----------------------------------------------------

		InputAttribute::create([
			'input_fields_id' => 14,
			'attributes_id' => 6,
		]);

		InputAttribute::create([
			'input_fields_id' => 14,
			'attributes_id' => 16,
		]);

		//-----------------------------------------------------

		InputAttribute::create([
			'input_fields_id' => 15,
			'attributes_id' => 6,
		]);

		InputAttribute::create([
			'input_fields_id' => 15,
			'attributes_id' => 14,
		]);

		InputAttribute::create([
			'input_fields_id' => 15,
			'attributes_id' => 15,
		]);

	}
}
