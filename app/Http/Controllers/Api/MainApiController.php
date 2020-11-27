<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Country;
use App\CustomerReview;
use App\Http\Controllers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Listing;
use App\Supplier;
use App\SupplierReview;
use App\Type;
use App\User;
use Illuminate\Http\Request;
use Validator;

class MainApiController extends Controller {
	use ApiResponse;

	public function categories(Request $request) {

		$categories = Category::whereNull('parent_id')->get();

		return $this->collection('CategoryResource', $categories);

	}

	public function types(Request $request) {

		$types = Type::all();

		return $this->collection('TypeResource', $types);

	}

	public function countries(Request $request) {

		$countries = Country::all();

		return $this->collection('CountryResource', $countries);

	}

	public function category_listings(Request $request, $id) {
		$listings = Listing::where('category_id', $id)->get();

		return $this->collection('ListingResource', $listings);
	}

	public function create_listing(Request $request) {

		$data_of_listing = $request->all();

		$validator = Validator::make($data_of_listing, [
			"name" => "required|string|max:100",
			"category_id" => "required|numeric|exists:categories,id",
			"description" => "required|string",
			"tags" => "required|string|max:50",
			"price" => "required|string",
			'main_photo' => 'required|image',
		]);

		if ($validator->fails()) {
			return $this->apiResponse(null, $validator->errors());
		}

		$data_of_listing['supplier_id'] = $this->api_user()->type_profile()->id;

		$listing = Listing::create($data_of_listing);

		$this->upload_image($listing->id);

		return $this->successResponse();

	}

	public function upload_image($id) {

		if (request()->hasFile('main_photo')) {

			$file_id = upload([

				'file' => 'main_photo',
				'type' => 'files',
				'folder' => 'listings/' . $id,
				'file_type' => 'listing',
				'relation_id' => $id,
			]);

			return response(['id' => $file_id], 200);

		}

	}

	public function add_review_to_listing(Request $request, $id) {

		$data = request()->all();

		$validator = Validator::make($data, [
			'body' => 'required|min:3|string',
			'rating' => 'required|numeric|min:1|max:5',
		]);

		if ($validator->fails()) {
			return $this->apiResponse(null, $validator->errors());
		}

		if ($data['rating'] < 3) {
			Report::create([
				'email' => user()->email,
				'listing' => Listing::find($id)->name,
				'reason' => $data['body'],
			]);
		}

		$data['listing_id'] = $id;

		$type_id = $this->api_user()->type_profile()->id;

		if ($this->api_user()->supplier) {
			$data['supplier_id'] = $type_id;
			SupplierReview::create($data);

		} else {
			$data['customer_id'] = $type_id;
			CustomerReview::create($data);

		}

		return $this->successResponse();
	}

	public function add_or_remove_favourite_supplier($id) {

		$customer = $this->api_user()->type_profile();

		$customer->favourite_suppliers()->toggle($id);

		return $this->successResponse();
	}

	public function suppliers_search() {

		$keyword = request('keyword');
		$category_id = request('category_id');
		$type_id = request('type_id');

		$result = Supplier::search($keyword, $category_id, $type_id);
		$suppliers = $result[0];

		$number_of_suppliers = $result[1];

		$suppliers->setPath('/suppliers');

		return $this->collection('SupplierResource', $suppliers);

	}

	public function featured_suppliers() {

		$suppliers = Supplier::withCount('visitor')->orderBy('visitor_count')->limit(10)->get();

		return $this->collection('SupplierResource', $suppliers);

	}

	public function my_favourite_suppliers() {

		$customer = $this->api_user()->type_profile();

		return $this->collection('SupplierResource', $customer->favourite_suppliers()->get());

	}

	public function profile($id) {

		$user = User::find($id);

		return $this->single_row('UserDetailsResource', $user);

	}

}
