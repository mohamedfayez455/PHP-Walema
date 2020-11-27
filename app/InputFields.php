<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InputFields extends Model
{
	protected $fillable = ['type' , 'name' , 'parent_id'];

    protected $table = "create_input_fields";

    public function attributes()
    {
    	return $this->belongsToMany(Attributes::class);
    }

    public function parents()
    {
    	return $this->hasMany('App\InputFields'  , 'parent_id', 'id');
    }

    public static function pluckNameWithIdFromInputField()
    {
    	return InputFields::where('parent_id' , null)->orWhere('parent_id' , '')->pluck('name' , 'id');
    }

    public static function findInputAttributs($input_id)
    {

    	return InputFields::find($input_id)->Attributes->toArray();
    }

    public static function findInputChildrens($input_id)
    {
    	return InputFields::where('parent_id' , $input_id)->get()->toArray();
    }
    
}
