<?php

namespace App;

use App\Favorite;
use App\Friend;
use App\Like;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model {

	protected $fillable = [
		'additional_data', 'token', 'user_id', 'verified',
	];

	public function verified() {
		return $this->token === null;
	}

	protected $appends = ['avatar', 'name', 'approved', 'phone', 'job',
	];

	public function getNameAttribute() {
		return $this->user->firstname . ' ' . $this->user->lastname;
	}

	public function favourite_suppliers() {
		return $this->belongsToMany('App\Supplier', 'favorites', 'customer_id', 'supplier_id');
	}

	public function getApprovedAttribute() {

		return $this->user->approved;
	}

	public function getPhoneAttribute() {

		return $this->additional_data['phone'] ?? '';
	}

	public function getJobAttribute() {

		return $this->additional_data['job'] ?? '';
	}

	public function getAdditionalDataAttribute($value) {
		return json_decode($value, true) ?? [];
	}

	public function getAvatarAttribute($value) {
		return $this->user->avatar;
	}

	public function user() {
		return $this->belongsTo('App\User', 'user_id', 'id');
	}

	public function suppliers() {
		return $this->belongsToMany('App\Supplier', 'customer_view_suppliers', 'customer_id', 'supplier_id');
	}

	public function listings() {
		return $this->belongsToMany('App\Listing', 'customer_listings', 'customer_id', 'listing_id');
	}

	public function reviews() {
		return $this->hasMany('App\CustomerReview', 'customer_id', 'id');
	}

	public function complaints() {
		return \App\EnquiryComplaint::where('sender_id', $this->user->id)->where('type', 'complaint')->get();
	}

	public function enquries() {
		return \App\EnquiryComplaint::where('sender_id', $this->user->id)->where('type', 'enquiry')->get();
	}

	public function sendVerificationEmail() {
		$this->notify(new \App\Notifications\VerifyCustomerEmail($this));
	}

	public function is_authorized() {
		return $this->verified == 1 and $this->approved == 1;
	}

	public function is_customer_liked_supplier($id) {

		return Like::where([
			'customer_id' => $this->id,
			'supplier_id' => $id,
		])->exists();

	}

	public function is_customer_favorite_supplier($id) {

		return Favorite::where([
			'customer_id' => $this->id,
			'supplier_id' => $id,
		])->exists();

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

		$friends = Friend::where('customer_id', $this->user->id)->orderBy('created_at', 'desc')->get();

		return $friends;
	}

	public function friends() {

		$friends = Friend::where('customer_id', $this->user->id)->get();

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

	public static function customer_of_country($code) {

		$country_id = Country::where('code', $code)->first()->id;
		$customers = User::whereRole('customer')->whereCountryId($country_id)->get();

		return $customers;
	}

}