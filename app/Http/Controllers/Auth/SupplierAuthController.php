<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Controller;

class SupplierAuthController extends Controller {

	public static function do_login() {

		$remember = request('remember') ? true : false;

		if (auth()->guard('supplier')->attempt(['email' => request('email'), 'password' => request('password')], $remember)) {

			if (!supplier()->user->verified) {
				auth()->guard('supplier')->logout();
				return back()->with('warning', 'You need to confirm your account. We have sent you an activation code, please check your email.');
			} else if (!supplier()->user->approved) {
				auth()->guard('supplier')->logout();
				return back()->with('warning', 'You need to wait for admin approval.');
			}

			return redirect()->route('supplier.supplier_edit_Profile');

		} else {
			return back()->with('error', 'Invalid Data');
		}

	}

	public static function register() {

		if (is_authenticated()) {
			return back()->with('warning', 'You Already Logged in');
		}

		return view('suppliers.register');

	}

	public static function do_register() {

		$supplier = new SupplierController();

		return $supplier->store(request(), true);

	}

	public static function logout() {
		auth()->guard('supplier')->logout();

		return redirect('/');
	}
}
