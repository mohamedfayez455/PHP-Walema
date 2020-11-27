<?php

use App\CustomersProfileFormInput;
use App\CustomersProfileFormsInputAttribute;
use Illuminate\Database\Seeder;

class CustomerFormbuilderSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$inputs = [

			'firstname' => [
				'input_id' => 5,
				'attributes' => [

					1 => 'First Name',
					2 => 'firstname',
					6 => 'on',
					7 => 'First Name',
					16 => 25,
				],
			],
			'lastname' => [
				'input_id' => 5,
				'attributes' => [
					1 => 'Last Name',
					2 => 'lastname',
					6 => 'on',
					7 => 'Last Name',
					16 => 25,
				],
			],
			'phone' => [
				'input_id' => 5,
				'attributes' => [
					1 => 'Phone',
					2 => 'phone',
					6 => 'on',
					7 => 'Phone',
					16 => 25,
				],
			],
			'email' => [
				'input_id' => 9,
				'attributes' => [

					1 => 'Email',
					2 => 'email',
					6 => 'on',
					7 => 'Your Email..',
					16 => 35,
				],
			],
			'address' => [
				'input_id' => 5,
				'attributes' => [
					1 => 'Address',
					2 => 'address',
					6 => 'on',
					7 => 'Address',
					16 => 25,
				],
			],
			'password' => [
				'input_id' => 10,
				'attributes' => [
					1 => 'Password',
					2 => 'password',
					6 => 'on',
					7 => 'Password',
					13 => 'on',
				],
			],
			'password_confirmation' => [
				'input_id' => 10,
				'attributes' => [
					1 => 'Password Confirmation',
					2 => 'password_confirmation',
					7 => 'Password Confirmation',
				],
			],
			'country_id' => [
				'input_id' => 2,
				'attributes' => [
					1 => 'Country',
					2 => 'country_id',
				],
			],
		];

		foreach ($inputs as $name => $value) {

			if (in_array($name, ['email', 'password', 'password_confirmation'])) {

				$customer_input = CustomersProfileFormInput::create([
					'input_id' => $value['input_id'],
					'published_on_profile' => 0,
					'published_on_signup' => 1,
				]);
			} else {

				$customer_input = CustomersProfileFormInput::create([
					'input_id' => $value['input_id'],
					'published_on_profile' => 1,
					'published_on_signup' => 1,
				]);
			}

			foreach ($value['attributes'] as $attr_id => $val) {

				CustomersProfileFormsInputAttribute::create([

					'input_id' => $customer_input->id,
					'attr_id' => $attr_id,
					'value' => $val,
				]);
			}

		}
	}
}
