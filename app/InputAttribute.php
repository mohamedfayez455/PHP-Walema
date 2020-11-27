<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InputAttribute extends Model
{
	protected $table = "attributes_input_fields";
    protected $fillable = ['attribute_id' , 'input_id'];

}
