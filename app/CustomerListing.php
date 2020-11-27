<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerListing extends Model {
	protected $fillable = [
		'customer_id',
		'listing_id',
	];

}
