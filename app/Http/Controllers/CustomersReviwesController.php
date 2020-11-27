<?php

namespace App\Http\Controllers;
use App\CustomerReview;
use App\Listing;
use App\Report;

class CustomersReviwesController extends Controller {
	/*
		this function will display all customers reviews
		public function CustomersReviwes() {
			$reviews = CustomerReview::all();

			return view('customers.reviews.reviews', compact('reviews'));
		}
	*/
	public function store() {
		$data = request()->validate([

			'body' => 'required|min:3|string',
			'listing_id' => 'required|exists:listings,id',
			'rating' => 'required|numeric|min:1|max:5',

		]);

		$data['customer_id'] = customer()->id;

		if ($data['rating'] < 3) {
			Report::create([
				'email' => user()->email,
				'listing' => Listing::find($data['listing_id'])->name,
				'reason' => $data['body'],
			]);
		}

		CustomerReview::create($data);

		return back()->with('success', 'Your Review Added');
	}

}
