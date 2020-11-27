<?php

namespace App;

use App\Category;
use App\Country;
use App\Friend;
use App\Search;
use App\User;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class Supplier extends Model {

	protected $appends = ["categories", "categories_id", 'avatar', 'name', 'approved', 'phone', 'all_listings',
	];

	protected $fillable = [
		'additional_data', 'user_id', 'token', 'verified',
	];

	protected $hidden = [
		'password', 'remember_token',
	];

	public function getNameAttribute() {

		return $this->user->firstname . ' ' . $this->user->lastname;
	}

	public function getPhoneAttribute() {

		return $this->additional_data['phone'] ?? '';
	}

	public function getApprovedAttribute() {

		return $this->user->approved;
	}

	public function getCategoriesAttribute() {

		$categories = '';

		foreach ($this->categories_id as $id) {
			$category = Category::find($id)->name;
			$categories .= $category . ' ,';
		}

		$categories = trim($categories, ',');

		return ($categories == '') ? 'This Supplier Does Not Belongs To Any Categories' : $categories;
	}

	public function getAdditionalDataAttribute($value) {
		return json_decode($value, true) ?? [];
	}

	public function verified() {
		return $this->token === null;
	}

	public function is_authorized() {
		return $this->verified == 1 and $this->approved == 1;
	}

	public function sendVerificationEmail() {
		$this->notify(new \App\Notifications\VerifySupplierEmail($this));
	}

	public function complaints() {
		return \App\EnquiryComplaint::where('reciever_id', $this->user->id)->where('type', 'complaint')->get();
	}

	public function enquries() {
		return \App\EnquiryComplaint::where('reciever_id', $this->user->id)->where('type', 'enquiry')->get();
	}

	public function getAvatarAttribute() {

		return $this->user->avatar;
	}

	public function getCategoriesIdAttribute($value) {

		$categories = $this->additional_data['categories_id'] ?? [];

		$ids = [];

		if (is_array($categories)) {

			foreach ($categories as $category) {

				$ids[] = $category;

			}
		} else {

			$ids[] = $categories;
		}

		return $ids;
	}

	public function parent_categories_id() {

		$ids = [];

		foreach ($this->categories_id as $id) {
			$category = Category::find($id);

			if (!$category->parent_id) {
				$ids[] = $id;
			}

		}

		return $ids;
	}

	public function sub_categories_id() {

		$ids = [];
		foreach ($this->categories_id as $id) {
			$category = Category::find($id);

			if ($category->parent_id) {
				$ids[] = $id;
			}

		}

		return $ids;
	}

	public function user() {
		return $this->belongsTo('App\User', 'user_id', 'id');
	}

	public function visitor() {
		return $this->belongsToMany('App\Customer', 'customer_view_suppliers', 'supplier_id', 'customer_id');
	}

	public function listings() {
		return $this->hasMany('App\Listing', 'supplier_id', 'id');
	}

	public function getAllListingsAttribute() {
		return count($this->listings);
	}

	public function customerSearchSupplier() {
		return $this->belongsToMany('App\Customer', 'search', 'supplier_id', 'customer_id');
	}

	public static function search($keyword, $category_id) {

		$users = User::query()
			->where('firstname', 'LIKE', "%$keyword%")
			->OrWhere('lastname', 'LIKE', "%$keyword%")
			->orWhere('email', 'LIKE', "%$keyword%")
			->get();

		$suppliers_after_filteration = [];

		$i = 0;

		foreach ($users as $user) {
			if ($user->role == 'supplier' and $user->supplier) {

				$supplier = $user->supplier;

				if ($category_id != 0) {

					if (!in_array($category_id, $supplier->categories_id)) {
						continue;
					}

				}

				$suppliers_after_filteration[] = $supplier;

				if (is_customer()) {

					Search::create([
						'customer_id' => customer()->id,
						'supplier_id' => $supplier->id,
					]);

				}

			}
			$i++;
		}

		return [self::paginate_supplier($suppliers_after_filteration), count($suppliers_after_filteration)];

	}

	public static function advancedSearch($categories_id, $subcategories_id) {

		$users = User::all();
		$suppliers_after_filteration = [];

		$data = DB::table('advanced_search')->first();

		$search_with_category = $data->search_with_category;
		$search_with_sub_category = $data->search_with_sub_category;

		foreach ($users as $user) {

			$supplier = $user->supplier;
			if ($user->role == 'supplier' and $supplier and supplier() != $supplier) {

				if ($search_with_category == 'on' and $categories_id != []) {

					$flag = false;

					foreach ($categories_id as $id) {

						if (!in_array($id, $supplier->parent_categories_id())) {
							$flag = false;
							continue;
						} else {
							$flag = true;
						}
					}

					if ($flag == false) {
						continue;
					}

				}

				if ($search_with_sub_category == 'on' and $subcategories_id != []) {

					$flag = false;

					foreach ($subcategories_id as $id) {

						if (!in_array($id, $supplier->sub_categories_id())) {
							$flag = false;
							continue;

						} else {
							$flag = true;
						}
					}

					if ($flag == false) {
						continue;
					}

				}

				$suppliers_after_filteration[] = $supplier;

				if (is_customer()) {

					Search::create([
						'customer_id' => customer()->id,
						'supplier_id' => $supplier->id,
					]);

				}

			}
		}

		return [self::paginate_supplier($suppliers_after_filteration), count($suppliers_after_filteration)];

	}

	public static function paginate_supplier($suppliers, $page = null) {

		$page = request('page') ?? 1;
		$perPage = 9;
		$offSet = ($page * $perPage) - $perPage;

		$itemsForCurrentPage = array_slice($suppliers, $offSet, $perPage, true);

		return new LengthAwarePaginator($itemsForCurrentPage, count($suppliers), $perPage, $page);
	}

	public function SupplierReview() {
		return $this->hasMany('App\SupplierReview', 'supplier_id', 'id');
	}

	public function CustomerReview() {
		return $this->hasMany('App\CustomerReview', 'customer_id', 'id');
	}

	public function getMessage($reciever_id) {

		$messages1 = Message::where('sender_id', $this->user->id)
			->where('reciever_id', $reciever_id)
			->orderBy('created_at', 'asc')->get();

		$messages2 = Message::where('sender_id', $reciever_id)
			->where('reciever_id', $this->user->id)
			->orderBy('created_at', 'asc')->get();

		$messages = $messages1->merge($messages2);

		$messages = $messages->toArray();

		$messages = quick_sort($messages);

		return $messages;

	}

	public function friends_collection() {

		$friends = Friend::where('supplier_id', $this->user->id)->orderBy('created_at', 'desc')->get();

		return $friends;
	}

	public function friends() {

		$friends = Friend::where('supplier_id', $this->user->id)->get();

		$all_users_of_customers = [];

		foreach ($friends as $friend) {

			$customerUser = $friend->customerUser;

			$all_users_of_customers[$customerUser->id] = $customerUser;

		}

		return $all_users_of_customers;
	}

	public static function supplier_of_country($code) {

		$country_id = Country::where('code', $code)->first()->id;

		$suppliers = User::whereRole('supplier')->whereCountryId($country_id)->get();

		return $suppliers;
	}

	public function profile_data() {

		$array = [];

		foreach ($this->additional_data as $name => $value) {

			if (!in_array($name, ['categories_id'])) {

				$array[$name] = $value;
			}

		}

		return $array;
	}

}