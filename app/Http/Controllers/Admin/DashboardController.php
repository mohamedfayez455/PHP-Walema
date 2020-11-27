<?php

namespace App\Http\Controllers\Admin;

use AdminAuth;
use App\Admin;
use App\ContactUs;
use App\Http\Controllers\Controller;
use App\Mail\AdminResetPassword;
use Hash;
use Illuminate\Http\Request;
use Mail;

class DashboardController extends Controller {
	public function index() {
		return view('admin/dashboard')->with('title', 'Admin Panel');
	}

	public function login() {
		return AdminAuth::login();
	}

	public function doLogin() {
		return AdminAuth::doLogin();

	}

	public function logout() {

		return AdminAuth::logout();
	}

	public function profile() {
		return view('admin/auth/profile')->with('title', 'Profile');
	}

	public function contact_us() {
	    $contacts = ContactUs::all();
		return view('admin/contact_us' , compact('contacts'));
	}

	public function forgot_password() {
		return view('admin/auth/forgot_password')->with('title', 'Forgot Password');
	}

	public function do_forgot_password() {

		$data = request()->validate([

			'email' => ['required', 'email', 'exists:admins,email'],

		]);

		$admin = Admin::where('email', $data['email'])->first();

		$token = app('auth.password.broker')->createToken($admin);

		Admin::createResetPassword($data, $token);

		Mail::to($admin->email)->send(new AdminResetPassword(['token' => $token, 'admin' => $admin]));

		return back()->with('success', 'The Link Reset Send');
	}

	public function reset_password($token) {

		$reset_password = Admin::getResetPasswordWithToken($token);

		if ($reset_password) {

			return view('admin/auth/reset_password')->with(['reset_password' => $reset_password, 'title' => 'Reset Password']);

		} else {

			return redirect(aurl('forgot-password'))->with('error', 'Please Send Reset Link Again');
		}
	}

	public function do_reset_password($token) {

		request()->validate([
			'email' => 'required|exists:admins,email',
			'password' => 'required|confirmed',
			'password_confirmation' => 'required',
		]);

		$reset_password = Admin::getResetPasswordWithToken($token);

		if ($reset_password) {

			Admin::DeleteResetPassword($token);

			Admin::updatePassword($reset_password);

			//Auth::guard('admin')->attempt(['email', $admin->email, 'password' => request('password')]);

			return redirect(aurl('login'))->with('success', 'You Can Login With New Password');

		} else {

			return redirect(aurl('forgot-password'))->with('error', 'Please Send Reset Link Again');
		}
	}

	public function update_password() {

		$data = request()->validate([

			'password' => 'required|string|min:3|max:20',
			'new_password' => 'required|string|min:3|max:20',
			'confirmation_password' => 'same:new_password',
		]);

		if (Hash::check($data['password'], admin()->password)) {

			admin()->update(['password' => bcrypt(request('new_password'))]);
		} else {
			return back()->with('error', 'Please enter correct current password');
		}

		return redirect()->route('admins.index')->with('success', 'Password Changed');
	}

}
