<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\UserResetPassword;
use App\User;
use CustomerAuth;
use Hash;
use Illuminate\Http\Request;
use Mail;
use SupplierAuth;

class UserAuthController extends Controller {

	public static function login() {

		if (is_authenticated()) {
			return back()->with('warning', 'You Already Logged in');
		}

		return view('auth.login');

	}
	public function do_login() {

		$data = request()->validate([

			'email' => 'required|email|exists:users,email',
		]);

		$role = User::whereEmail($data['email'])->first()->role;

		if ($role == 'supplier') {
			return SupplierAuth::do_login();
		} elseif ($role == 'customer') {
			return CustomerAuth::do_login();

		}

		return back()->with('error', 'Unknown Role');
	}

	public function forgot_password() {
		return view('auth.forgot_password');
	}

	public function do_forgot_password() {

		$data = request()->validate([

			'email' => ['required', 'email', 'exists:users,email'],

		]);

		$user = User::where('email', $data['email'])->first();

		$token = app('auth.password.broker')->createToken($user);

		User::createResetPassword($data, $token);

		Mail::to($user->email)->send(new UserResetPassword(['token' => $token, 'user' => $user]));

		return back()->with('status', 'The Link Reset Send');
	}

	public function reset_password($token) {

		$reset_password = User::getResetPasswordByToken($token);

		if ($reset_password) {

			return view('auth.passwords.reset')->with(['reset_password' => $reset_password, 'title' => 'Reset Password']);

		} else {

			return redirect()->route('auth.passwords.forgot_password')->with('status', 'Please Send Reset Link Again');
		}
	}

	public function do_reset_password($token) {

		request()->validate([
			'email' => 'required|exists:users,email',
			'password' => 'required|confirmed',
			'password_confirmation' => 'required',
		]);

		$reset_password = User::getResetPasswordByToken($token);

		if ($reset_password) {

			User::deleteResetPassword($token);

			$user = User::updatePassword($reset_password);

			return redirect()->route('login')->with('success', 'You Can Login With New Password');

		} else {

			return redirect()->route('forgot_password')->with('error', 'Please Send Reset Link Again');
		}
	}

	public function update_password() {

		$data = request()->validate([

			'current_password' => 'required|string|min:3|max:20',
			'new_password' => 'required|string|min:3|max:20',
			'confirmation_password' => 'same:new_password',
		]);

		if (Hash::check($data['current_password'], user()->password)) {

			user()->update(['password' => bcrypt(request('new_password'))]);
		} else {
			return back()->with('error', 'Please enter correct current password');
		}

		return back()->with('success', 'Password Changed');
	}

}
