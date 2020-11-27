<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminRegisterController extends Controller {
	public static function login() {
		return view('admin/auth/login')->with('title', 'Log in');
	}

	public static function doLogin() {
		$remember = request('remember') ? true : false;

		if (auth()->guard('admin')->attempt(['email' => request('email'), 'password' => request('password')], $remember)) {

			return redirect()->route('dashboard.index');

		} else {
			return back()->with('error', 'Invalid Data');
		}

	}

	public static function logout() {

		auth('admin')->logout();

		return redirect()->route('admin.login');
	}
}
