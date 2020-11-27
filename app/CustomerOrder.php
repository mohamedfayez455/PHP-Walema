<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerrOrder extends Model {
	protected $fillable = [
		'amount',
		'status',
		'customer',
	];
}
