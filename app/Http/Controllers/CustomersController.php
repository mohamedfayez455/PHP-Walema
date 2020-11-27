<?php

namespace App\Http\Controllers;

use App\Customer;
use App\SupplierViewCustomer;
use App\User;
use CustomerAuth;
use Illuminate\Http\Request;

class CustomersController extends Controller {
	/*this function will display all customers users */
	public function customers_list() {

		if (request('page') >= 2 && !is_supplier()) {

			return back();

		}

		$customers = Customer::paginate(9);
		$number_of_customers = count(Customer::all());

		return view('customers.list')->with(['customers' => $customers, 'number_of_customers' => $number_of_customers]);
	}

	public function customers_register() {
		return CustomerAuth::register();

	}

	/*this function will display all customers profile */

	public function do_customers_register() {

		return CustomerAuth::do_register();

	}

	public function logout() {
		return CustomerAuth::logout();
	}

	public function customer_edit_Profile() {
		return view('customers.profile.edit_profile')->with('title', 'Edit Profile');
	}

	public function do_customer_edit_Profile() {

		$data = request()->except('_token');

		$main_data = [];
		$additional_data = [];

		$main_data = request()->validate([

			'firstname' => 'required|string|max:25',
			'lastname' => 'required|string|max:25',
			'country_id' => 'required|exists:countries,id',
		]);

		user()->update($main_data);

		$keys_of_data = array_keys($main_data);

		foreach ($keys_of_data as $key) {
			unset($data[$key]);
		}

		foreach ($data as $name => $value) {

			if (is_array($value)) {

				foreach ($value as $val) {

					if (is_object($val)) {

						$additional_data[$name] = $this->upload_avatar($name, $val);

					} else {

						$additional_data[$name] = $value;
					}

				}

			} else {
				if (is_object($value)) {

					$additional_data[$name] = $this->upload_avatar($name, $value);

				} else {

					$additional_data[$name] = $value;
				}

			}

		}

		$additional_data = json_encode(($additional_data));

		$status = customer()->update(['additional_data' => $additional_data]);

		return redirect()->route('customer.profile', customer()->id)->with('success', 'Profile Completed Successfully');

	}

	public function upload_avatar($name, $value) {
		$class_name = explode('\\', get_class($value));

		$class = end($class_name);

		if ($class == 'UploadedFile') {

			$cont_avatar = json_decode(customer()->additional_data, true)['avatar'] ?? '';

			return upload([
				'file' => $name,
				'type' => 'single',
				'folder' => 'customers',
				'delete_file' => $cont_avatar,
			]);

		}
	}

	public function customer_profile($id) {

		$customer = Customer::find($id);

		if ($customer) {

			$supplier_id = supplier()->id ?? [];

			if ($supplier_id) {

				SupplierViewCustomer::create(['supplier_id' => $supplier_id, 'customer_id' => $id]);
			}

			return view('customers.profile.my_profile', ['customer' => $customer]);

		}

		return back()->with('error', 'Can Not Load This Profile');

	}

	public function customer_country($country) {

		$customers = Customer::customer_of_country($country);

		return response($customers, 200);
	}

}
