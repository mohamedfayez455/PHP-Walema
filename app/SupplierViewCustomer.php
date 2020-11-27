<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierViewCustomer extends Model {
	protected $fillable = ['supplier_id', 'customer_id'];
}
