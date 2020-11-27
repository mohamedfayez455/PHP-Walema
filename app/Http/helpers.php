<?php

if (!function_exists('active')) {

	function active($segment = '') {

		if (Request::segment(2) == $segment) {
			return ['active'];
		}

		return [''];

	}

}

if (!function_exists('aurl')) {

	function aurl($url) {

		return url('admin/' . trim($url, '/'));

	}

}

if (!function_exists('validate_image')) {

	function validate_image($extension = null) {
		if ($extension == null) {

			return 'image|mimes:jpg,jpeg,png,gif,bnp,svg';

		} else {

			return 'image|mimes:' . $extension;

		}

	}

}

if (!function_exists('upload')) {

	function upload($data) {
		return App\Http\Controllers\Upload::upload($data);

	}

}

if (!function_exists('delete_file')) {

	function delete_file($data) {
		return App\Http\Controllers\Upload::delete_file($data);

	}

}

if (!function_exists('delete')) {

	function delete($data) {
		return App\Http\Controllers\Upload::delete($data);

	}

}

if (!function_exists('setting')) {

	function setting() {
		$first = App\Setting::first();

		if ($first) {
			return $first;
		} else {
			return App\Setting::create([
				'app_name' => 'WALEMA',
				'icon' => '',
				'email' => '',
				'description' => '',
				'status' => 'open',
				'message_maintenance' => '',
			]);
		}

	}

}

if (!function_exists('app_name')) {

	function app_name() {
		return App\Setting::first()->app_name ?? 'Walema';

	}

}

if (!function_exists('admin')) {

	function admin() {
		return Auth::guard('admin')->user();

	}

}

if (!function_exists('supplier')) {

	function supplier() {

		$user = Auth::guard('supplier')->user();
		if ($user) {

			return $user->supplier;
		}

		return null;

	}

}

if (!function_exists('is_supplier')) {

	function is_supplier() {
		return Auth::guard('supplier')->check();

	}

}

if (!function_exists('supplier_photo')) {

	function supplier_photo() {

		return supplier()->avatar ? Storage::url(supplier()->avatar) : '';

	}

}

if (!function_exists('customer')) {

	function customer() {

		$user = Auth::guard('customer')->user();
		if ($user) {

			return $user->customer;
		}

		return null;
	}

}

if (!function_exists('customer_photo')) {

	function customer_photo() {

		return (customer()->avatar) ? Storage::url($customer_photo) : '';

	}

}

if (!function_exists('is_customer')) {

	function is_customer() {
		return Auth::guard('customer')->check();

	}

}

if (!function_exists('is_authenticated')) {

	function is_authenticated() {
		return is_supplier() || is_customer();

	}

}

if (!function_exists('is_guest')) {

	function is_guest() {
		return !is_supplier() and !is_customer();

	}

}

if (!function_exists('user')) {

	function user() {
		if (is_supplier()) {
			return supplier()->user;
		} else if (is_customer()) {
			return customer()->user;
		}

		return false;

	}

}
/*
if (!function_exists('is_user')) {

function is_user() {
return Auth::guard('web')->check();

}

}
 */
if (!function_exists('load_array_of')) {

	function load_array_of($name) {

		$result = [];

		if (preg_match('/categories/i', $name, $match)) {

			$result = App\Category::pluck('name', 'id');

		} else if (preg_match('/types/i', $name, $match)) {

			$result = App\Type::pluck('name', 'id');

		} else if (preg_match('/country/i', $name, $match)) {

			$result = App\Country::pluck('name', 'id');

		}

		return json_encode($result);

	}

}

if (!function_exists('load_categories')) {

	function load_categories($select = null, $category_hide = null) {

		$categories = App\Category::get(['id', 'name', 'parent_id']);

		$categories_arr = [];
		$list_arr['icon'] = '';
		$list_arr['li_attr'] = '';
		$list_arr['a_attr'] = '';
		$list_arr['children'] = [''];

		foreach ($categories as $category) {

			$category_arr = [];

			if (is_array($select)) {

				foreach ($select as $id) {

					if ($id == $category->id) {

						$category_arr['state'] = [
							'opened' => true,
							'disabled' => false,
							'selected' => true,
						];

					}

				}

			} elseif ($select != null and $select == $category->id) {

				$category_arr['state'] = [
					'opened' => true,
					'disabled' => false,
					'selected' => true,
				];
			}

			if ($category_hide != null and $category_hide == $category->id) {

				$category_arr['state'] = [
					'hidden' => true,
					'disabled' => true,
				];
			}

			$category_arr['id'] = $category->id;
			$category_arr['text'] = $category->name;
			$category_arr['parent'] = ($category->parent_id) ?: '#';

			array_push($categories_arr, $category_arr);

		}

		return json_encode($categories_arr, JSON_UNESCAPED_UNICODE);

	}

}

if (!function_exists('advanced_search')) {

	function advanced_search() {

		$data = DB::table('advanced_search')->first();

		$search_with_category = $data->search_with_category;
		$search_with_sub_category = $data->search_with_sub_category;
		$search_with_type = $data->search_with_type;

		return [
			'search_with_category' => $search_with_category,
			'search_with_sub_category' => $search_with_sub_category,
			'search_with_type' => $search_with_type,
		];
	}

}

if (!function_exists('popular_listings')) {

	function popular_listings() {

		if (is_customer()) {

			$listings = customer()->listings ?? [];

		} elseif (is_supplier()) {
			$listings = supplier()->listings;

		}

		$returned_listings = [];

		foreach ($listings as $listing) {

			if ($listing->all_review) {

				$returned_listings[$listing->id] = $listing;

			}

		}

		$returned_listings = quick_sort($returned_listings);

		$length = count($returned_listings);

		return array_slice($returned_listings, $length - 6 > 0 ? $length - 6 : 0, $length);
	}

}

if (!function_exists('popular_categories')) {

	function popular_categories() {

		$returned_categories = [];

		foreach (popular_listings() as $listing) {

			if ($listing->category->all_listings) {

				$returned_categories[$listing->category->id] = $listing->category;

			}

		}
		$returned_categories = quick_sort($returned_categories);

		$length = count($returned_categories);

		return array_slice($returned_categories, $length - 6 > 0 ? $length - 6 : 0, $length);
	}

}

if (!function_exists('recent_user')) {

	function recent_user() {

		$all_users = [];

		if (is_supplier()) {
			$friends = App\Friend::where('supplier_id', supplier()->user->id)->get();

			foreach ($friends as $friend) {

				$customerUser = $friend->customerUser;

				$all_users[$customerUser->id] = $customerUser;

			}

		} elseif (is_customer()) {

			$friends = App\Friend::where('customer_id', customer()->user->id)->get();

			foreach ($friends as $friend) {

				$supplierUser = $friend->supplierUser;

				$all_users[$supplierUser->id] = $supplierUser;

			}

		}

		$all_users = quick_sort($all_users);

		$length = count($all_users);

		return array_slice($all_users, $length - 6 > 0 ? $length - 6 : 0, $length);

	}

}

if (!function_exists('quick_sort')) {
	function quick_sort($my_array) {

		$loe = $gt = [];

		if (count($my_array) < 2) {
			return $my_array;
		}
		$pivot_key = key($my_array);
		$pivot = array_shift($my_array);
		foreach ($my_array as $val) {
			if ($val >= $pivot) {
				$loe[] = $val;
			} elseif ($val < $pivot) {
				$gt[] = $val;
			}
		}

		return array_merge(quick_sort($loe), array($pivot_key => $pivot), quick_sort($gt));
	}
}