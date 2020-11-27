<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource {
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request) {
		return [
			'id' => $this->id,
			'about' => $this->about,
			'created_at' => $this->created_at,
			'email' => $this->email,
			'firstname' => $this->firstname,
			'lastname' => $this->lastname,
			'avatar' => $this->avatar,
			'role' => $this->role,
			'type' => $this->type,
			'phone' => $this->phone,
			'country_id' => $this->country_id,
		];
	}
}
