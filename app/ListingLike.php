<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListingLike extends Model {
	protected $fillable = ['user_id', 'listing_id'];
}
