<?php

namespace App;

use App\ListingLike;
use Carbon\Carbon;
use DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject {
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	/**
	 * Get the identifier that will be stored in the subject claim of the JWT.
	 *
	 * @return mixed
	 */
	public function getJWTIdentifier() {
		return $this->getKey();
	}

	/**
	 * Return a key value array, containing any custom claims to be added to the JWT.
	 *
	 * @return array
	 */
	public function getJWTCustomClaims() {
		return [];
	}

	//protected $guard = ['customer', 'supplier'];

	protected $fillable = [
		'email', 'firstname', 'lastname', 'role', 'password', 'token', 'phone', 'about', 'verified', 'approved', 'avatar', 'country_id',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**

	 *return true if the user is verified email

	 *@return bool

	 */

	public function verified() {
		return $this->token === null and $this->verified == 1;
	}

	public function sendVerificationEmail() {

		$this->notify(new \App\Notifications\VerifyUserEmail($this));
	}

	public function supplier() {
		return $this->belongsTo('App\Supplier', 'id', 'user_id');
	}

	public function customer() {
		return $this->belongsTo('App\Customer', 'id', 'user_id');
	}

	public function type_profile() {
		if ($this->supplier) {
			return $this->supplier;
		}

		return $this->customer;

	}

	public function country() {
		return $this->hasOne('App\Country', 'id', 'country_id');
	}

	public function is_authorized() {
		return $this->verified == 1 and $this->approved == 1;
	}

	public function links() {
		return $this->hasOne('App\SocialNetwork', 'user_id', 'id');
	}

	public function last_message_info($id) {
		return Message::where(function ($query) use ($id) {
			return $query->where('sender_id', $this->id)
				->where('reciever_id', $id);
		})->orWhere(function ($query) use ($id) {
			return $query->where('sender_id', $id)
				->where('reciever_id', $this->id);
		})->orderBy('created_at', 'desc')
			->first();
	}

	public static function createResetPassword($data, $token) {
		DB::table('password_resets')->insert([
			'email' => $data['email'],
			'token' => $token,
			'created_at' => Carbon::now(),
		]);
	}

	public static function getResetPasswordByToken($token) {
		return DB::table('password_resets')->where('token', $token)->where('created_at', '>', Carbon::now()->subHours(2))->first();
	}

	public static function deleteResetPassword($token) {
		DB::table('password_resets')->where('token', $token)->where('created_at', '>', Carbon::now()->subHours(2))->delete();
	}

	public static function updatePassword($reset_password) {
		User::where('email', $reset_password->email)->update(['password' => bcrypt(request('password'))]);
	}

	public function is_user_liked_listing($listing_id) {
		$listing_like = ListingLike::where(['listing_id' => $listing_id, 'user_id' => $this->id])->first();

		if ($listing_like) {
			return true;
		}
		return false;
	}

	public function review() {

		$rating = 0;
		$all_review = 1;

		if ($this->role == 'supplier') {

			$listings = $this->supplier->listings;
		} elseif ($this->role == 'customer') {
			$listings = $this->customer->listings;
		}

		foreach ($listings as $listing) {

			$supReviews = $listing->SupplierReview ?? [];

			$conReviews = $listing->CustomerReview ?? [];

			foreach ($supReviews as $review) {
				$rating = $rating + $review->rating;
			}

			foreach ($conReviews as $review) {
				$rating = $rating + $review->rating;
			}

			$all_review = $all_review + count($listing->SupplierReview) + count($listing->CustomerReview);

		}

		$avg = $rating / $all_review;

		return $avg;
	}

}
