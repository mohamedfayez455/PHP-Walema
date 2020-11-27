<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerViewSupplier extends Model {
	protected $fillable = ['supplier_id', 'customer_id'];
}
