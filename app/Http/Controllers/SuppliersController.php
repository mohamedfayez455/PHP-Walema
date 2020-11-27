<?php

namespace App\Http\Controllers;

use App\CustomerViewSupplier;
use App\Http\Controllers\Controller;
use App\Listing;
use App\Supplier;
use App\User;
use Illuminate\Http\Request;
use Response;
use SupplierAuth;

class SuppliersController extends Controller {

	public function suppliers_list() {

		if (request('page') >= 2 && !is_customer()) {

			return redirect('/login')->with('error', 'You Must Login To Continue');

		}
		if (request('search') || request('keyword')) {

			$keyword = request('keyword');
			$category_id = request('category_id');

			$result = Supplier::search($keyword, $category_id);
			$suppliers = $result[0];

			$number_of_suppliers = $result[1];

			$suppliers->setPath('/suppliers');

		} elseif (request('advanced_search')) {
			$categories_id = request('categories_id') ?? [];
			$subcategories_id = request('subcategories_id') ?? [];

			$result = Supplier::advancedSearch($categories_id, $subcategories_id);

			$suppliers = $result[0];

			$number_of_suppliers = $result[1];

			$suppliers->setPath('/suppliers');

		} else {

			$suppliers = Supplier::paginate(9);
			$number_of_suppliers = count(Supplier::all());

		}

		if (request()->ajax()) {
			return Response::json(view('suppliers.suppliers_card', ['suppliers' => $suppliers, 'number_of_suppliers' => $number_of_suppliers])->render());
		} else {
			return view('suppliers.list')->with(['suppliers' => $suppliers, 'number_of_suppliers' => $number_of_suppliers]);
		}
	}

	public function suppliers_register() {

		return SupplierAuth::register();

	}

	public function do_suppliers_register() {

		return SupplierAuth::do_register();

	}

	public function suppliers_edit_Profile() {

		$listings = Listing::where('supplier_id', supplier()->id)->paginate(10);

		return view('suppliers.profile.edit_profile')->with(['title', 'Edit Profile', 'listings' => $listings, 'number_of_listings' => count($listings)]);

	}

	public function do_supplier_edit_Profile() {

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

		$status = supplier()->update(['additional_data' => $additional_data]);

		return redirect()->route('supplier.profile', supplier()->id)->with('success', 'Profile Completed Successfully');
	}

	public function upload_avatar($name, $value) {
		$class_name = explode('\\', get_class($value));

		$class = end($class_name);

		if ($class == 'UploadedFile') {

			$supp_avatar = json_decode(supplier()->additional_data, true)['avatar'] ?? '';

			return upload([
				'file' => $name,
				'type' => 'single',
				'folder' => 'suppliers',
				'delete_file' => $supp_avatar,
			]);

		}
	}

	public function logout() {
		return SupplierAuth::logout();
	}

	public function supplier_profile($id) {

		$supplier = Supplier::find($id);

		if ($supplier) {

			$customer_id = customer()->id ?? null;

			if ($customer_id) {

				CustomerViewSupplier::create(['supplier_id' => $id, 'customer_id' => $customer_id]);
			}

			return view('suppliers.profile.my_profile', ['supplier' => $supplier]);

		}

		return back()->with('error', 'Supplier Can Not Found');

	}

	public function supplier_country($country) {
		$suppliers = Supplier::supplier_of_country($country);

		return response($suppliers, 200);
	}

}
