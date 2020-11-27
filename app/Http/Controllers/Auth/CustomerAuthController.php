<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Controller;

class CustomerAuthController extends Controller {

	public static function do_login() {

		$remember = request('remember') ? true : false;

		if (auth()->guard('customer')->attempt(['email' => request('email'), 'password' => request('password')], $remember)) {

			if (!customer()->user->verified()) {
				auth()->guard('customer')->logout();
				return back()->with('warning', 'You need to confirm your account. We have sent you an activation code, please check your email.');
			} else if (!customer()->user->approved) {
				auth()->guard('customer')->logout();
				return back()->with('warning', 'You need to wait for admin approval.');
			}
			return redirect()->route('customer.customer_edit_Profile');

		} else {
			return back()->with('error', 'Invalid Data');
		}

	}

	public static function register() {

		if (is_authenticated()) {

			return back()->with('warning', 'You Already Logged in');
		}

		return view('customers.register');

	}

	/*this function will display all customers profile */

	public static function do_register() {

		$customers = new CustomerController();

		return $customers->store(request(), true);

	}

	public static function logout() {

		auth()->guard('customer')->logout();

		return redirect('/');
	}
}
