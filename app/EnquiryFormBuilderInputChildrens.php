<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnquiryFormBuilderInputChildrens extends Model {
	protected $fillable = [
		'enquiry_input_id', 'input_id', 'name', 'value',
	];

	protected $table = 'enquiry_form_builder_input_childrens';

	public function input() {
		return $this->hasOne('App\InputFields', 'id', 'input_id');
	}

	public function Forminput() {
		return $this->hasOne('App\EnquiryFormBuilderInput', 'id', 'enquiry_input_id');
	}
}
