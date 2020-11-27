<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Search extends Model {

	protected $fillable = ['customer_id', 'supplier_id'];
	protected $table = 'search';

	public function supplier() {
		return $this->belongsTo('App\Supplier', 'supplier_id', 'id');
	}

	public function customer() {
		return $this->belongsTo('App\Customer', 'customer_id', 'id');
	}
}
