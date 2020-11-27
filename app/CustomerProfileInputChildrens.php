<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerProfileInputChildrens extends Model {
	protected $fillable = [
		'customer_input_id', 'input_id', 'name', 'value',
	];

	public function input() {
		return $this->hasOne('App\InputFields', 'id', 'input_id');
	}

	public function Forminput() {
		return $this->hasOne('App\CustomersProfileFormInput', 'id', 'customer_input_id');
	}
}
