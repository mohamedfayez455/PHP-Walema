<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Type extends Model {
	protected $table = "types";

	protected $fillable = [
		'name', 'desc', 'slug', 'photo',
	];

	protected $appends = [
		'photo_path',
	];

	public function getPhotoPathAttribute() {
		return Storage::url($this->photo);
	}
}
