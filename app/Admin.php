<?php

namespace App;

use Carbon\Carbon;
use DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Storage;

class Admin extends Authenticatable {
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $guard = 'admin';

	protected $fillable = [
		'firstname', 'lastname', 'email', 'password', 'photo',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function getPhotoAttribute($photo) {

		if (!$photo) {
			return url("/img/default_user.png");
		}

		return Storage::url($photo);
	}

	public function getAdminByEmail($email) {
		return Admin::whereEmail($email)->first();
	}

	public static function createResetPassword($data, $token) {
		DB::table('admins_password_resets')->insert([
			'email' => $data['email'],
			'token' => $token,
			'created_at' => Carbon::now(),
		]);
	}

	public static function getResetPasswordWithToken($token) {
		return DB::table('admins_password_resets')->where('token', $token)->where('created_at', '>', Carbon::now()->subHours(2))->first();
	}

	public static function DeleteResetPassword($token) {
		DB::table('admins_password_resets')->where('token', $token)->where('created_at', '>', Carbon::now()->subHours(2))->delete();
	}

	public static function updatePassword($reset_password) {
		Admin::where('email', $reset_password->email)->update(['password' => bcrypt(request('password'))]);
	}
}
