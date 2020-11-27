<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierReview extends Model {
	protected $fillable = [
		'supplier_id',
		'listing_id',
		'body',
		'rating',
	];

	//protected $with = ['supplier'];
	/*
	protected $appends = ['user'];

	public function getUserAttribute()
	{
		return $this->supplier->user;
	}
	*/

	public static function yourReviews() {
		return SupplierReview::where('supplier_id', supplier()->id)->paginate(2);
	}

	public static function getYourReviewsBySupplierIdAndListingId($id) {

		return SupplierReview::where('supplier_id', supplier()->id)->where('listing_id', $id)->paginate(2);
	}

	public function supplier() {
		return $this->belongsTo('App\Supplier', 'supplier_id', 'id');
	}
}
