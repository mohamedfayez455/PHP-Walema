<?php

namespace App\Http\Controllers;

use App\User;

class VerifyController extends Controller {

	public function UserVerify($token) {
		$user = User::where('token', $token)->first();

		if ($user) {

			if (!$user->verified) {
				$user->verified = 1;
				$user->save();
				$status = 'success';
				$result = "Your e-mail is verified. You can now login.";
			} else {
				$status = 'warning';
				$result = "Your e-mail is already verified. You can now login.";
				return redirect("/" . $user->role . "s/login")->with($status, $result);
			}

			$user->token = null;
			$user->save();

		} else {
			$status = 'warning';
			$result = "Sorry your email cannot be identified.";
		}

		return back();

	}

}
