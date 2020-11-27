<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerReview extends Model {
	protected $fillable = [
		'customer_id',
		'listing_id',
		'body',
		'rating',
	];

	protected $appends = ['user', 'all_replies'];

	public function getUserAttribute() {
		return $this->customer->user;
	}

	public function getAllRepliesAttribute() {
		return $this->replies;
	}

	public static function getReviewByListingId($id) {

		return CustomerReview::where('listing_id', $id)->paginate(2);
	}

	public static function getVisitorReviewsByListingId($id) {
		return CustomerReview::where('listing_id', $id)->paginate(2);
	}

	public function customer() {
		return $this->belongsTo('App\Customer', 'customer_id', 'id');
	}

	public function replies() {
		return $this->hasMany('App\ReviewReply', 'review_id', 'id');
	}
}
