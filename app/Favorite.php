<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model {
	protected $fillable = ['customer_id', 'supplier_id'];
}
