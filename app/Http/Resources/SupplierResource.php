<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class SupplierResource extends Resource {
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request) {

		$is_favourite = false;

		if (auth('api')->user() and auth('api')->user()->customer()) {
			$is_favourite = auth('api')->user()->customer->is_customer_favorite_supplier($this->id);
		}

		return [
			'id' => $this->id,
			'is_favourite' => $is_favourite,
			'user' => new UserResource($this->user),
			'additional_data' => $this->additional_data,
		];
	}
}
