<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ListingResource extends Resource {
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request) {

		return [
			'id' => $this->id,
			'category_id' => $this->category_id,
			'photo_path' => $this->photo_path,
			'supplier' => new SupplierResource($this->supplier),
			'category' => new CategoryResource($this->category),
			'supplier_id' => $this->supplier_id,
			'price' => $this->price,
			'name' => $this->name,
			'created_at' => $this->created_at->toDateTimeString(),
			'rating' => $this->review(),
		];
	}
}
