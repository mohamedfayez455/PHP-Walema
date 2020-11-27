<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomersProfileFormsInputAttribute extends Model {
	protected $fillable = ['input_id', 'attr_id', 'value'];

	public function input() {
		return $this->hasOne('App\CustomersProfileFormInput');
	}

	public function Attribute() {
		return $this->belongsTo('App\Attributes', 'attr_id', 'id');
	}
}
