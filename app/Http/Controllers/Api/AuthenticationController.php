<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\Http\Controllers\Api\ApiResponse;
use App\Http\Controllers\Controller;
//use App\Mail\UserResetPassword;
use App\Supplier;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Mail;
use Validator;

class AuthenticationController extends Controller {
	use ApiResponse;

	public function login() {
		$validator = Validator::make(request()->all(), [
			'email' => 'required|string|email|exists:users,email|max:255',
			'password' => 'required|string',
		]);

		if ($validator->fails()) {
			return $this->apiResponse(null, $validator->errors());
		}

		$user = User::where('email', request('email'))->first();

		if ($user->approved == 1) {

			if ($user and Hash::check(request('password'), $user->password)) {
				return $this->login_user($user, str_random(32));
			}
		} else {
			return $this->successResponse(null, 'waiting for admin Approval');

		}

		return $this->failedResponse(null, 'Invalid Data');
	}

	public function login_user($user, $token = null) {

		$token = JWTAuth::fromUser($user);

		$user->update(['api_token' => $token]);
//		$user = new UserResource($user);

		return $this->apiResponse([
			'user' => $user,
			'api_token' => $token,

		], 'Logged in successfully', 200);
	}

	public function logout() {

		try {
			$user = $this->api_user();

			if ($user) {

				$user->update(['api_token' => '']);

				auth('api')->logout();

				return $this->successResponse(null, 'Logout');
			}

		} catch (Exception $e) {
		}

		return $this->failedResponse();

	}

	public function register(Request $request) {
		$data = Validator::make(request()->all(), [
			'firstname' => 'required',
			'lastname' => 'required|string',
			'country_id' => 'required',
			'role' => 'required|string|in:supplier,customer',
			'email' => 'required|string|email|unique:users,email|max:255',
			'password' => 'required|min:6',
			'categories_id' => 'sometimes|nullable|array',
			'types_id' => 'sometimes|nullable|array',
		]);
		if ($data->fails()) {
			return $this->apiResponse(null, $data->errors());
		}

		$user = User::create([
			'firstname' => $request->firstname,
			'lastname' => $request->lastname,
			'country_id' => $request->country_id,
			'email' => $request->email,
			'role' => $request->role,
			'password' => bcrypt($request->password),
			'token' => str_random(25),
		]);

		if ($user->role == 'supplier') {

			$additional_data = [
				'categories_id' => $request->categories_id,
				'types_id' => $request->types_id,
			];

			$supplier = Supplier::create([
				'additional_data' => json_encode($additional_data),
				'user_id' => $user->id,
			]);
			if ($user->approved == 1) {
				return $this->login_user($user);
			} else {
				return $this->successResponse(null, 'waiting for admin Approval');
			}

		} else {
			$customers = Customer::create([
				'additional_data' => '{}',
				'user_id' => $user->id,
			]);

			$user->update(['approved' => 1]);
			return $this->successResponse(null, 'success login');

		}

	}

	public function forgot_password() {
		$data = request()->validate([
			'email' => ['required', 'email', 'exists:users,email'],
		]);
		$user = User::where('email', $data['email'])->first();
		$token = app('auth.password.broker')->createToken($user);
		User::createResetPassword($data, $token);
		Mail::to($user->email)->send(new UserResetPassword(['token' => $token, 'user' => $user]));
		return $this->successResponse(null, 'The Link Reset Send');
	}

	public function reset_password() {
		request()->validate([
			'email' => 'required|exists:users,email',
			'password' => 'required|confirmed',
			'password_confirmation' => 'required',
			'token' => 'required',
		]);
		$reset_password = User::getResetPasswordByToken(\request('token'));
		if ($reset_password) {
			User::deleteResetPassword(\request('token'));
			$user = User::updatePassword($reset_password);
			return $this->successResponse(null, 'You Can Login With New Password');
		} else {
			return $this->failedResponse(null, 'Please Send Reset Link Again');
		}
	}

	public function update_password() {

		$data = request()->validate([
			'current_password' => 'required|string|min:3|max:20',
			'new_password' => 'required|string|min:3|max:20',
			'confirmation_password' => 'same:new_password',
		]);

		if (user()) {

			if (Hash::check($data['current_password'], user()->password)) {
				dd("ss");
				user()->update(['password' => bcrypt(request('new_password'))]);
			} else {
				return $this->failedResponse(null, 'Please enter correct current password');

			}

			return $this->successResponse(null, 'Password Changed');

		}

		return $this->failedResponse(null, 'error .  try again');

	}

}
