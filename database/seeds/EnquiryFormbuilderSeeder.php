<?php

use App\EnquiryFormBuilderInput;
use App\EnquiryFormBuilderInputAttribute;
use App\EnquiryFormBuilderInputChildrens;
use Illuminate\Database\Seeder;

class EnquiryFormbuilderSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$inputs = [

			'type' => [
				'input_id' => 2,
				'attributes' => [

					1 => 'Type',
					2 => 'type',
				],
			],

			'email' => [
				'input_id' => 9,
				'attributes' => [

					1 => 'Email',
					2 => 'email',
					7 => 'Your Email',
				],
			],

			'name' => [
				'input_id' => 5,
				'attributes' => [

					1 => 'Name',
					2 => 'name',
					7 => 'Name',
				],
			],

			'message' => [
				'input_id' => 14,
				'attributes' => [

					1 => 'Message',
					2 => 'message',
				],
			],

		];

		foreach ($inputs as $name => $value) {

			if (in_array($name, ['types_id', 'categories_id'])) {

				$enquiry_input = EnquiryFormBuilderInput::create([
					'input_id' => $value['input_id'],
					'publish' => 1,
				]);
			} elseif (in_array($name, ['email', 'password', 'password_confirmation'])) {

				$enquiry_input = EnquiryFormBuilderInput::create([
					'input_id' => $value['input_id'],
					'publish' => 1,
				]);
			} else {
				$enquiry_input = EnquiryFormBuilderInput::create([
					'input_id' => $value['input_id'],
					'publish' => 1,
				]);
			}

			foreach ($value['attributes'] as $attr_id => $val) {

				EnquiryFormBuilderInputAttribute::create([

					'input_id' => $enquiry_input->id,
					'attr_id' => $attr_id,
					'value' => $val,
				]);
			}

		}

		EnquiryFormBuilderInputChildrens::create([
			'enquiry_input_id' => 1,
			'input_id' => 4,
			'name' => 'Enquiry',
			'value' => 'enquiry',
		]);

		EnquiryFormBuilderInputChildrens::create([
			'enquiry_input_id' => 1,
			'input_id' => 4,
			'name' => 'Complaint',
			'value' => 'complaint',
		]);

	}
}
