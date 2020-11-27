<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model {
	protected $fillable = ['customer_id', 'supplier_id'];

	public function supplier() {
		return $this->belongsTo('App\Supplier', 'supplier_id', 'id');
	}

	public function customer() {
		return $this->belongsTo('App\Customer', 'customer_id', 'id');
	}

}
