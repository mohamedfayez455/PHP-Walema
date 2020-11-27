<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
use App\Favorite;
use App\Like;
use App\Supplier;

Route::get('/get-full-chat-off', 'MessagesController@get_full_chat_off')->name('get_full_chat_off');

Route::get('/', function () {

	$categories = App\Category::whereNull('parent_id')->whereHas('childs')->with('childs')->get();
	$listings = App\Listing::withCount('likes')->orderBy('likes_count')->limit(9)->get();

	return view('welcome', compact('categories', 'listings'));
})->name('welcome');

Route::get('/contact', function () {
	return view('contact');
})->name('contact');

Route::get('/about-us', function () {
	return view('about_us');
})->name('about_us');

Route::group(['middleware' => 'supplierAuth:supplier'], function () {

	Route::get('suppliers/edit/profile', [
		'as' => 'supplier.supplier_edit_Profile',
		'uses' => 'SuppliersController@suppliers_edit_Profile',
	]);
	Route::post('suppliers/edit/profile', [
		'as' => 'supplier.do_supplier_edit_Profile',
		'uses' => 'SuppliersController@do_supplier_edit_Profile',
	]);

	Route::get('suppliers/orders', [
		'as' => 'suppliersorders',
		'uses' => 'SuppliersOrdersController@suppliersorders',
	]);

	Route::get('suppliers/listings', [
		'as' => 'suppliers.listings',
		'uses' => 'SuppliersListingsController@listing',
	]);

	Route::get('suppliers/addlisting/{id?}', [
		'as' => 'suppliers.add_listings',
		'uses' => 'SuppliersListingsController@add_listings',
	]);

	Route::get('/supplier/reply/review', function () {

		App\ReviewReply::create(['review_id' => request('review_id'), 'supplier_id' => supplier()->id, 'body' => request('body')]);

		return count(App\ReviewReply::whereReviewId(request('review_id'))->get());

	});

	Route::post('suppliers/addlisting/{id}', [
		'as' => 'suppliers.store_listing',
		'uses' => 'SuppliersListingsController@store_listing',
	]);

	Route::post('suppliers/deleteListing/{id}', [
		'as' => 'suppliers.delete_listing',
		'uses' => 'SuppliersListingsController@delete_listing',
	]);

	Route::get('suppliers/reviews/{id?}', [
		'as' => 'suppliersreviwes',
		'uses' => 'SuppliersReviwesController@suppliersReviwes',
	]);

	Route::post('suppliers/reviews', [
		'as' => 'supplier_review.store',
		'uses' => 'SuppliersReviwesController@store',
	]);

	Route::any('suppliers/logout', [
		'as' => 'suppliers.logout',
		'uses' => 'SuppliersController@logout',
	]);

	Route::post('/upload/image/{id}', 'SuppliersListingsController@upload_image');
	Route::delete('/delete/image/{id}', 'SuppliersListingsController@delete_image');
	Route::post('/upload/main/image/{id}', 'SuppliersListingsController@upload_main_image');
	Route::delete('/delete/main/image/{id}', 'SuppliersListingsController@delete_main_image');
});

Route::group(['middleware' => 'customerAuth:customer'], function () {

	Route::get('customers/edit/profile', [
		'as' => 'customer.customer_edit_Profile',
		'uses' => 'CustomersController@customer_edit_Profile',
	]);

	Route::post('customers/edit/profile', [
		'as' => 'customer.do_customer_edit_Profile',
		'uses' => 'CustomersController@do_customer_edit_Profile',
	]);

	Route::get('customers/orders', [
		'as' => 'customersorders',
		'uses' => 'customersOrdersController@customersOrders',
	]);

	Route::post('customers/reviews', [
		'as' => 'contracor_review.store',
		'uses' => 'customersReviwesController@store',
	]);

	Route::any('customers/logout', [
		'as' => 'customers.logout',
		'uses' => 'CustomersController@logout',
	]);

	Route::get('/customers/like/{id}', function ($id) {

		$supplier = Supplier::find($id);

		if ($supplier) {

			$exists = Like::where([
				'customer_id' => customer()->id,
				'supplier_id' => $id,
			])->exists();

			if (!$exists) {
				Like::create([
					'customer_id' => customer()->id,
					'supplier_id' => $id,
				]);

				return response(['response' => 'liked'], 200);
			} else {

				return response(['response' => 'you already liked it'], 404);
			}

		}

		return response(['response' => 'supplier does not found'], 404);

	});
	Route::get('/customers/unlike/{id}', function ($id) {

		$supplier = Supplier::find($id);

		if ($supplier) {
			$like = Like::where([
				'customer_id' => customer()->id,
				'supplier_id' => $id,
			])->first();

			if ($like) {
				$like->delete();

				return response(['response' => 'unliked'], 200);
			}

			return response(['response' => 'supplier does not liked by current customer'], 404);
		}

		return response(['response' => 'supplier does not found'], 404);

	});

	Route::get('/customers/favorite/{id}', function ($id) {

		$supplier = Supplier::find($id);

		if ($supplier) {

			$exists = Favorite::where([
				'customer_id' => customer()->id,
				'supplier_id' => $id,
			])->exists();

			if (!$exists) {

				Favorite::create([
					'customer_id' => customer()->id,
					'supplier_id' => $id,
				]);

				return response(['response' => 'favorite'], 200);
			} else {
				return response(['response' => 'you already add it to favorite list'], 404);
			}
		}

		return response(['response' => 'supplier does not found'], 404);

	});
	Route::get('/customers/unfavorite/{id}', function ($id) {

		$supplier = Supplier::find($id);

		if ($supplier) {
			$favorite = Favorite::where([
				'customer_id' => customer()->id,
				'supplier_id' => $id,
			])->first();

			if ($favorite) {
				$favorite->delete();
				return response(['response' => 'unfavorite'], 200);
			}

			return response(['response' => 'supplier does not added to favorite by current customer'], 404);
		}

		return response(['response' => 'supplier does not found'], 404);

	});

});

Route::get('/get-array-of/{name}', function ($name) {

	if (request()->ajax()) {
		return load_array_of($name);
	}

	return [];

});

Route::get('/get-all-country', function () {

	return response(App\Country::pluck('name', 'code'), 200);

});

Route::POST('/contact', 'ContactUsController@send')->name('contact');

Route::get('/suppliers', [
	'as' => 'suppliers_list',
	'uses' => 'SuppliersController@suppliers_list',
]);

Route::get('/customers', [
	'as' => 'customers_list',
	'uses' => 'CustomersController@customers_list',
]);

Route::get('/alliances', function () {
	return view('alliances');
})->name('alliances');

Route::get('/case-studies', function () {
	return view('case_studies');
})->name('case_studies');

Route::get('/suppliers_profile_builder/get_profile_builder', 'Admin\SuppliersProfileBuilderController@getProfileBuilder')->name('front_suppliers_profile_builder.get_profile_builder');

Route::get('/customers_profile_builder/get_profile_builder', 'Admin\CustomersProfileBuilderController@getProfileBuilder')->name('front_customers_profile_builder.get_profile_builder');

Route::get('/enquiry_form_builder/get_profile_builder', 'Admin\EnquiryFormBuilderController@getProfileBuilder')->name('front_enquiry_form_builder.get_profile_builder');

Route::group(['middleware' => 'notauth'], function () {

	Route::get('/login', 'Auth\UserAuthController@login')->name('login');
	Route::post('/login', 'Auth\UserAuthController@do_login')->name('login');

	Route::get('/suppliers/register', [
		'as' => 'suppliers.register',
		'uses' => 'SuppliersController@suppliers_register',
	]);

	Route::POST('/suppliers/register', [
		'as' => 'suppliers.register',
		'uses' => 'SuppliersController@do_suppliers_register',
	]);

	Route::get('/customers/register', [
		'as' => 'customers.register',
		'uses' => 'CustomersController@customers_register',
	]);

	Route::POST('/customers/register', [
		'as' => 'customers.register',
		'uses' => 'CustomersController@do_customers_register',
	]);

	Route::get('/verify/user/{token}', [
		'as' => 'user.verify',
		'uses' => 'VerifyController@UserVerify',
	]);

	Route::get('/forgot/password', 'Auth\UserAuthController@forgot_password')->name('forgot_password');

	Route::post('/forgot/password', 'Auth\UserAuthController@do_forgot_password')->name('forgot_password');

	Route::get('/reset/password/{token}', 'Auth\UserAuthController@reset_password')->name('reset_password');

	Route::post('/reset/password/{token}', 'Auth\UserAuthController@do_reset_password')->name('reset_password');

});

Route::group(['middleware' => 'authenticated', 'guard' => ['supplier', 'customer']], function () {

	Route::get('/dashboard', 'HomeController@index')->name('dashboard');

	Route::get('/suppliers/listings/{id}', 'SuppliersListingsController@show')->name('listings.show');

	Route::get('/suppliers/profile/{id}', [
		'as' => 'supplier.profile',
		'uses' => 'SuppliersController@supplier_profile',
	]);

	Route::get('/customers/profile/{id}', [
		'as' => 'customer.profile',
		'uses' => 'CustomersController@customer_profile',
	]);

	Route::get('/customers/profile/{id}', [
		'as' => 'customer.profile',
		'uses' => 'CustomersController@customer_profile',
	]);

	Route::get('/listings/rating/{id}', [
		'as' => 'listing.rating',
		'uses' => 'SuppliersReviwesController@rating',
	]);

	Route::get('/listings/like/{id}', [
		'as' => 'listing.like',
		'uses' => 'SuppliersListingsController@like',
	]);

	Route::get('/listings/unlike/{id}', [
		'as' => 'listing.unlike',
		'uses' => 'SuppliersListingsController@unlike',
	]);

	Route::put('/user/update/password', [
		'as' => 'user.update_password',
		'uses' => 'Auth\UserAuthController@update_password',
	]);

	Route::post('/chat/message', 'MessagesController@store');
	Route::get('/chat/message', 'MessagesController@getMessage');

	Route::post('/send/enquiry/{id}', 'EnquiriesComplaintsController@send');

});

Route::get('/suppliers/{country}', [
	'as' => 'supplier.country',
	'uses' => 'SuppliersController@supplier_country',
]);

Route::get('/customers/{country}', [
	'as' => 'supplier.country',
	'uses' => 'CustomersController@customer_country',
]);

Route::post('/newsletter', 'Admin\NewsletterController@subscribe')->name('subscribe.newsletter');
