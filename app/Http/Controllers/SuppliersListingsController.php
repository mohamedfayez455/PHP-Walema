<?php

namespace App\Http\Controllers;

use App\CustomerListing;
use App\Listing;
use App\ListingLike;
use Illuminate\Http\Request;
use Storage;

class SuppliersListingsController extends Controller {
	/*this function will display all suplliers listings */
	public function listing() {
		$listings = Listing::getAllListingWithPaginate();
		return view('suppliers.listings.listings', compact('listings'));
	}

	public function show($id) {

		$listing = Listing::find($id);

		if ($listing and $listing->status == 'active') {

			if (is_customer()) {

				$exists = CustomerListing::where(['customer_id' => customer()->id, 'listing_id' => $id])->exists();

				if (!$exists) {

					CustomerListing::create(['customer_id' => customer()->id, 'listing_id' => $id]);
				}

			}
			return view('suppliers.listings.listing', compact('listing'));
		} elseif ($listing) {

			return back()->with('warning', 'Listing Need To Be Approved By Admin');

		}

		return back()->with('error', 'Listing Not Found');
	}

	/*this function will display suplliers add listing  page */

	public function add_listings($id = null) {

		if ($id) {

			$listing = Listing::find($id);

			if (!$listing) {
				return redirect()->route('suppliers.listings')->with('error', 'Listing Not Found');
			}

		} else {

			$listing = Listing::create([
				'name' => null,
				'description' => null,
				'address' => null,
				'category_id' => 1,
				'price' => null,
				'tags' => null,
				'supplier_id' => supplier()->id,
			]);

		}

		return view('suppliers.listings.store_listings', ['listing' => $listing]);
	}

/*this function will store suplliers  listing  in Database */

	public function upload_image($id) {

		if (request()->hasFile('photo')) {

			request()->validate([
				'photo' => 'required|max:5048|' . validate_image(),
			]);

			$file_id = upload([

				'file' => 'photo',
				'type' => 'files',
				'folder' => 'listings/' . $id,
				'file_type' => 'listing',
				'relation_id' => $id,
			]);

			return response(['id' => $file_id], 200);

		}

	}

	public function delete_image($id) {

		if ($id) {
			delete($id);
		}

	}

	public function delete_main_image($id) {

		if ($id) {

			$listing = Listing::find($id);

			Storage::has($listing->main_photo) ? Storage::delete($listing->main_photo) : '';
			$listing->main_photo = '';
			$listing->save();

		}

	}

	public function upload_main_image($id) {

		if (request()->hasFile('main_photo')) {

			request()->validate([
				'main_photo' => 'required|max:5048|' . validate_image(),
			]);

			$listing = Listing::find($id);

			$this->delete_main_image(($listing->id));

			$main_photo = upload([

				'type' => 'single',
				'file' => 'main_photo',
				'folder' => 'listing/' . $id,

			]);

			$listing->main_photo = $main_photo;
			$listing->save();

		}

		return response(['main_photo' => $listing->main_photo], 200);

	}

	public function store_listing(Request $request, $id) {

		$data_of_listing = $request->validate([

			"name" => "required|string|max:100",
			"category_id" => "required|numeric|exists:categories,id",
			"description" => "required|string",
			"tags" => "required|string|max:50",
			"price" => "required|string",
		]);

		$listing = Listing::find($id);

		if (!$listing) {
			return redirect()->route('suppliers.listings')->with('error', 'Listing Not Found');
		}

		$listing->update($data_of_listing);

		return redirect()->route('suppliers.listings')->with('success', 'Wonderfull');

	}

	public function delete_listing($id) {
		$listing = Listing::find($id);

		foreach ($listing->files as $file) {
			delete($file->id);
		}

		Storage::has($listing->main_photo) ? Storage::delete($listing->main_photo) : '';

		$listing->delete();

		return back()->with('success', 'Listing Has Been Deleted');

	}

	public function like($id) {
		$like = ListingLike::where(['listing_id' => $id, 'user_id' => user()->id])->first();

		if (!$like) {

			ListingLike::create([
				'user_id' => user()->id,
				'listing_id' => $id,
			]);

			$status = 'Added Successfully';
			$code = 200;
		} else {
			$status = 'UnExpected Error On Adding';
			$code = 404;
		}

		$likes = count(Listing::find($id)->likes);

		return response(['status' => $status, 'likes' => $likes], $code);
	}

	public function unlike($id) {
		$like = ListingLike::where(['listing_id' => $id, 'user_id' => user()->id])->first();

		if ($like) {

			$like->delete();
			$status = 'Deleted Successfully';
			$code = 200;
		} else {
			$status = 'UnExpected Error On Deleting';
			$code = 404;

		}

		$likes = count(Listing::find($id)->likes);

		return response(['status' => $status, 'likes' => $likes], $code);
	}

}
