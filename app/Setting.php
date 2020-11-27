<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	protected $fillable = ['app_name' , 'icon' , 'email', 'description' , 'status', 'message_maintenance'];
}
