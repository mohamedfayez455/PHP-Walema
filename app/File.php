<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model {
	protected $fillable = [
		'id',
		'name',
		'size',
		'file',
		'path',
		'full_path',
		'mime_type',
		'file_type',
		'relation_id',
	];
}
