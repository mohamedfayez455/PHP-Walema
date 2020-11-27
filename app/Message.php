<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {
	protected $fillable = [

		'sender_id',
		'reciever_id',
		'content',
		'type',

	];

	protected $with = ['sender'];

	public function reciever() {
		return $this->belongsTo('App\User', 'reciever_id', 'id');
	}

	public function sender() {
		return $this->belongsTo('App\User', 'sender_id', 'id');
	}

}
