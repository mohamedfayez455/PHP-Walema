<?php

namespace App;

use App\CustomerListing;
use Illuminate\Database\Eloquent\Model;
use Storage;

class Listing extends Model {
	protected $fillable = [
		'name',
		'description',
		'price',
		'tags',
		'category_id',
		'main_photo',
		'status',
		'supplier_id',
	];

	protected $appends = ['all_review', 'photo_path'];

	public function files() {
		return $this->hasMany('App\File', 'relation_id', 'id')->where('file_type', 'listing');
	}

	public function getPhotoPathAttribute() {
		return Storage::url($this->main_photo);
	}

	public function category() {
		return $this->belongsTo('App\Category', 'category_id', 'id');
	}

	public function SupplierReview() {
		return $this->hasMany('App\SupplierReview', 'listing_id', 'id');
	}

	public function supplier() {
		return $this->belongsTo('App\Supplier', 'supplier_id');
	}

	public function CustomerReview() {
		return $this->hasMany('App\CustomerReview', 'listing_id', 'id');
	}

	public function getAllReviewAttribute() {
		return count($this->SupplierReview) + count($this->CustomerReview);
	}

	public static function getAllListingWithPaginate() {
		return Listing::where('supplier_id', supplier()->id)->where('name', '!=', null)->where('description', '!=', null)->paginate(9);
	}

	public static function getAllListings() {
		return Listing::where('supplier_id', supplier()->id)->where('name', '!=', null)->where('description', '!=', null)->get();
	}

	public function likes() {
		return $this->hasMany('App\ListingLike', 'listing_id', 'id');
	}

	public function review() {
		$rating = 0;

		foreach ($this->CustomerReview as $review) {
			$rating = $rating + $review->rating;
		}

		foreach ($this->SupplierReview as $review) {
			$rating = $rating + $review->rating;
		}

		$all_review = $this->all_review == 0 ? 1 : $this->all_review;

		$avg = $rating / $all_review;

		return $avg;
	}

	public function visits() {

		return CustomerListing::where('listing_id', $this->id)->get();
	}

}
