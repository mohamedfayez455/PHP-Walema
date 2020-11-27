<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialNetwork extends Model {
	protected $fillable = ['linked_in', 'facebook', 'twitter', 'youtube', 'user_id'];
}
