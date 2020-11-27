<?php

namespace App\Http\Controllers;

use App\CustomerReview;
use App\Listing;
use App\Report;
use App\SupplierReview;

class SuppliersReviwesController extends Controller {
	/*this function will display all suplliers reviews */

	public function suppliersReviwes($id = null) {

		$your_reviews = SupplierReview::yourReviews();
		$visitor_reviews = [];
		$lsitings = Listing::getAllListings();

		if ($id == null) {

			foreach ($lsitings as $lsiting) {

				$visitor_reviews = CustomerReview::getReviewByListingId($lsiting->id);

			}
		}

		if (request()->ajax()) {

			if ($id) {
				$your_reviews = SupplierReview::getYourReviewsBySupplierIdAndListingId($id);
				$visitor_reviews = CustomerReview::getVisitorReviewsByListingId($id);
			}

			if (count($your_reviews) > count($visitor_reviews)) {
				$pagination = $your_reviews;
			} else {
				$pagination = $visitor_reviews;
			}

			return response([
				'your_reviews' => view('suppliers.reviews.your_reviews', compact('your_reviews', 'pagination'))->render(),
				'visitor_reviews' => view('suppliers.reviews.visitor_reviews', compact('visitor_reviews'))->render(),
			], 200);
		}

		return view('suppliers.reviews.reviews', ['lsitings' => $lsitings]);

	}

	public function store() {
		$data = request()->validate([

			'body' => 'required|min:3|string',
			'listing_id' => 'required|exists:listings,id',
			'rating' => 'required|numeric|min:1|max:5',

		]);

		$data['supplier_id'] = supplier()->id;

		if ($data['rating'] < 3) {
			Report::create([
				'email' => user()->email,
				'listing' => Listing::find($data['listing_id'])->name,
				'reason' => $data['body'],
			]);
		}

		SupplierReview::create($data);

		return back()->with('success', 'Your Review Added');
	}

	public function rating($id) {
		if (request()->ajax() and request()->has('vote')) {

			if (is_customer()) {
				$review = CustomerReview::find($id);

				if ($review and $review->customer == customer()) {
					$review->rating = request('vote');
					$review->save();

					if ($review->rating < 3) {
						Report::create([
							'email' => user()->email,
							'listing' => Listing::find($review->listing_id)->name,
							'reason' => $review->body,
						]);
					}

					return response(['status' => true], 200);

				} else {
					return response(['status' => false], 200);
				}

			} else if (is_supplier()) {
				$review = SupplierReview::find($id);

				if ($review and $review->supplier == supplier()) {

					$review->rating = request('vote');
					$review->save();

					if ($review->rating < 3) {
						Report::create([
							'email' => user()->email,
							'listing' => Listing::find($review->listing_id)->name,
							'reason' => $review->body,
						]);
					}

					return response(['status' => true], 200);

				} else {
					return response(['status' => false], 200);
				}
			}

		}
	}

}
