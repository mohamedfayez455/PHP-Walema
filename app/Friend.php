<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model {
	protected $fillable = [
		'customer_id',
		'supplier_id',
	];

	public function customerUser() {
		return $this->belongsTo('App\User', 'customer_id', 'id');
	}

	public function supplierUser() {
		return $this->belongsTo('App\User', 'supplier_id', 'id');
	}

}
