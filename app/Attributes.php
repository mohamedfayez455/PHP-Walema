<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attributes extends Model
{
	protected $fillable = [ 'attribute' , 'type'];


    public function inputs()
    {
    	return $this->belongsToMany(InputFields::class);
    }
}
