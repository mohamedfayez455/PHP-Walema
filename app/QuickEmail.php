<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuickEmail extends Model {
	protected $fillable = ['email_to', 'subject', 'message'];
}
