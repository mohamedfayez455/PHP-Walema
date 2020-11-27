<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::group(['middleware' => 'api_middleware'], function () {

	Route::post('/add-review-to-listing/{id}', 'MainApiController@add_review_to_listing');
	Route::post('/add-or-remove-favourite-supplier/{id}', 'MainApiController@add_or_remove_favourite_supplier');
	Route::post('/create-listing', 'MainApiController@create_listing');
	Route::get('/my-favourite-suppliers', 'MainApiController@my_favourite_suppliers');

	Route::post('/chat/message', 'MessagesController@store');
	Route::get('/chat/message', 'MessagesController@getMessage');

});

Route::post('/login', 'AuthenticationController@login')->name('login');
Route::post('/register', 'AuthenticationController@register')->name('register');

Route::post('/forgot_password', 'AuthenticationController@forgot_password')->name('forgot_password');
Route::post('/reset_password', 'AuthenticationController@reset_password')->name('reset_password');
Route::post('/update_password', 'AuthenticationController@update_password')->name('update_password');

Route::get('/countries', 'MainApiController@countries');
Route::get('/categories', 'MainApiController@categories');
Route::get('/category-listings/{id}', 'MainApiController@category_listings');
Route::get('/types', 'MainApiController@types');
Route::get('/profile/{id}', 'MainApiController@profile');
Route::get('/suppliers-search', 'MainApiController@suppliers_search');
Route::get('/featured-suppliers', 'MainApiController@featured_suppliers');
