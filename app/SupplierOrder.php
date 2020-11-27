<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierOrder extends Model {
	protected $fillable = [
		'amount',
		'status',
		'customer',
	];
}
