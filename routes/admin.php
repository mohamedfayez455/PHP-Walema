<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'guard' => 'admin'], function () {

	//Config::set('auth.defaults.guard' , 'admin');

	Route::group(['middleware' => 'admin'], function () {

		Route::get('/users/chat-history/{id}', 'SupplierController@chat_history')->name('users.chat_history');

		Route::get('/', 'DashboardController@index')->name('dashboard.index');
		Route::get('/profile', 'DashboardController@profile')->name('admin.profile');
		Route::put('/update/password', 'DashboardController@update_password')->name('admins.update_password');
		Route::get('/logout', 'DashboardController@logout')->name('admin.logout');
		Route::get('/contact_us', 'DashboardController@contact_us')->name('admin.contact_us');

		Route::get('/suppliers_profile_builder/get_input_attribute', 'SuppliersProfileBuilderController@getInputAttribute')->name('suppliers_profile_builder.get_input_attribute');

		Route::get('/enquiry_form_builder/get_input_attribute', 'EnquiryFormBuilderController@getInputAttribute')->name('enquiry_form_builder.get_input_attribute');

		Route::get('/suppliers_profile_builder/get_input_attribute_with_value', 'SuppliersProfileBuilderController@getInputAttributeWithValue')->name('suppliers_profile_builder.get_input_attribute_with_value');

		Route::get('/enquiry_form_builder/get_input_attribute_with_value', 'EnquiryFormBuilderController@getInputAttributeWithValue')->name('enquiry_form_builder.get_input_attribute_with_value');

		Route::get('/customers_profile_builder/get_input_attribute_with_value', 'CustomersProfileBuilderController@getInputAttributeWithValue')->name('customers_profile_builder.get_input_attribute_with_value');

		Route::get('/enquiry_form_builder/get_profile_builder', 'EnquiryFormBuilderController@getProfileBuilder')->name('enquiry_form_builder.get_profile_builder');

		Route::get('/suppliers_profile_builder/get_profile_builder', 'SuppliersProfileBuilderController@getProfileBuilder')->name('suppliers_profile_builder.get_profile_builder');

		Route::get('/customers_profile_builder/get_profile_builder', 'CustomersProfileBuilderController@getProfileBuilder')->name('customers_profile_builder.get_profile_builder');

		Route::get('/suppliers_profile_builder/edit_form_builder', 'SuppliersProfileBuilderController@editFormBuilder')->name('suppliers_profile_builder.edit_form_builder');

		Route::get('/enquiry_form_builder/edit_form_builder', 'EnquiryFormBuilderController@editFormBuilder')->name('enquiry_form_builder.edit_form_builder');

		Route::get('/customers_profile_builder/edit_form_builder', 'CustomersProfileBuilderController@editFormBuilder')->name('customers_profile_builder.edit_form_builder');

		Route::resource('/enquiry_form_builder', 'EnquiryFormBuilderController');

		Route::resource('/suppliers_profile_builder', 'SuppliersProfileBuilderController');

		Route::resource('/customers_profile_builder', 'CustomersProfileBuilderController');

		Route::resource('/admins', 'AdminController');
		Route::delete('/admins/destroy/all', 'AdminController@destroyAll');

		Route::get('supplier/approve/{id}', function ($id) {

			$user = App\Supplier::find($id)->user;
			if ($user) {
				$user->approved = 1;

				$user->save();

				return response(['response' => 'approved'], 200);
			}

			return response(['response' => 'error'], 404);
		});

		Route::get('supplier/unapprove/{id}', function ($id) {

			$user = App\Supplier::find($id)->user;
			if ($user) {

				$user->approved = 0;

				$user->save();

				return response(['response' => 'unapproved'], 200);

			}

			return response(['response' => 'error'], 404);
		});

		Route::get('customers/approve/{id}', function ($id) {

			$user = App\Customer::find($id)->user;
			if ($user) {
				$user->approved = 1;

				$user->save();

				return response(['response' => 'approved'], 200);
			}

			return response(['response' => 'error'], 404);
		});

		Route::get('customers/unapprove/{id}', function ($id) {

			$user = App\Customer::find($id)->user;
			if ($user) {

				$user->approved = 0;

				$user->save();

				return response(['response' => 'unapproved'], 200);

			}

			return response(['response' => 'error'], 404);
		});

		Route::get('/newsletter', 'NewsletterController@getMailingList')->name('dashboard.newsletter');
		Route::get('/listings', 'LsitingController@index')->name('dashboard.listings');

		Route::get('listings/active/{id}', function ($id) {

			$listing = App\Listing::find($id);
			if ($listing) {

				$listing->status = 'active';

				$listing->save();

				return response(['response' => 'active'], 200);
			}

			return response(['response' => 'error'], 404);
		});

		Route::get('listings/pending/{id}', function ($id) {

			$listing = App\Listing::find($id);
			if ($listing) {

				$listing->status = 'pending';

				$listing->save();

				return response(['response' => 'pending'], 200);
			}

			return response(['response' => 'error'], 404);
		});

		Route::get('listings/canceled/{id}', function ($id) {

			$listing = App\Listing::find($id);
			if ($listing) {

				$listing->status = 'canceled';

				$listing->save();

				return response(['response' => 'canceled'], 200);
			}

			return response(['response' => 'error'], 404);
		});

		Route::resource('/suppliers', 'SupplierController');
		Route::delete('/suppliers/destroy/all', 'SupplierController@destroyAll');

		Route::resource('/customers', 'CustomerController');
		Route::delete('/customers/destroy/all', 'CustomerController@destroyAll');

		Route::resource('/supplier-categories', 'SupplierCategoryController');
		Route::delete('/supplier-categories/destroy/all', 'SupplierCategoryController@destroyAll');

		Route::get('/settings', 'SettingController@index')->name('settings.index');
		Route::put('/settings', 'SettingController@update')->name('settings.update');

		Route::get('/supplier-advanced-filter', 'SettingController@supplier_advanced_search')->name('settings.supplier_advanced_filter');
		Route::put('/supplier-advanced-filter', 'SettingController@do_supplier_advanced_search')->name('settings.supplier_advanced_filter');

		Route::get('/send/quick-emails', 'EmailController@send_quick_emails');
		Route::get('/send/reports', 'EmailController@get_reports')->name('dashboard.reports');

	});

	Route::group(['middleware' => 'notadmin'], function () {
		Route::get('/login', 'DashboardController@login')->name('admin.login');
		Route::post('/login', 'DashboardController@doLogin')->name('admin.doLogin');
		Route::get('/forgot-password', 'DashboardController@forgot_password')->name('admin.forgot_password');
		Route::post('/forgot-password', 'DashboardController@do_forgot_password')->name('admin.do_forgot_password');

		Route::get('/reset-password/{token}', 'DashboardController@reset_password')->name('admin.reset_password');
		Route::post('/reset-password/{token}', 'DashboardController@do_reset_password')->name('admin.do_reset_password');
	});

});