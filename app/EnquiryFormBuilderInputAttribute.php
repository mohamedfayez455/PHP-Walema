<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnquiryFormBuilderInputAttribute extends Model {
	protected $fillable = ['input_id', 'attr_id', 'value'];

	protected $table = 'enquiry_form_builder_input_attributes';

	public function input() {
		return $this->hasOne('App\EnquiryFormBuilderInput');
	}

	public function Attribute() {
		return $this->belongsTo('App\Attributes', 'attr_id', 'id');
	}
}
