<?php

namespace App\Http\Controllers;
class HomeController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('authenticated');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		if (is_supplier()) {

			return view('supplier_dashboard');

		} elseif (is_customer()) {

			return view('customer_dashboard');
		} else {

			return redirect('/');

		}
	}

/*
public function update_image() {

$avatar = upload([

'type' => 'single',
'file' => 'avatar',
'folder' => 'users',
'delete_file' => user()->avatar,

]);

user()->avatar = $avatar;

user()->save();

return back()->with('success', 'Image Uploaded');
}
 */

}
