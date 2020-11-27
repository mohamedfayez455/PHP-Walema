<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnquiryComplaint extends Model {

	protected $table = 'enquiries_complaints';
	protected $fillable = ['email', 'type', 'message', 'name', 'sender_id', 'additional_data', 'reciever_id'];

	public function sender() {
		return $this->belongsTo('App\User', 'sender_id');
	}

	public function reciever() {
		return $this->belongsTo('App\User', 'reciever_id');
	}

}
