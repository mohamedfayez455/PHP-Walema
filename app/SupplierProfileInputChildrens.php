<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierProfileInputChildrens extends Model
{
	protected $fillable = [
		'supplier_input_id', 'input_id' , 'name' , 'value'
	];

	public function input()
    {
        return $this->hasOne('App\InputFields', 'id' , 'input_id');
    }

	public function inputForm()
    {
        return $this->hasOne('App\SuppliersProfileFormInput' , 'id' , 'supplier_input_id');
    }
}
