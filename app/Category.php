<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Category extends Model {
	protected $table = "categories";

	protected $fillable = ['name', 'desc', 'parent_id', 'photo'];
	protected $appends = [
		'all_listings',
		'photo_path',
	];

	public function parent() {
		require $this->hasOne('App\Category', 'id', 'parent_id');
	}

	public function childrens($parent_id) {
		return Category::where('parent_id', $parent_id)->get();
	}

	public function childs() {
		return $this->hasMany('App\Category', 'parent_id');

	}

	public function listings() {
		return $this->hasMany('App\Listing', 'category_id', 'id');
	}

	public function getAllListingsAttribute() {
		return count($this->listings);
	}

	public function getPhotoPathAttribute() {
		return Storage::url($this->photo);
	}

}
