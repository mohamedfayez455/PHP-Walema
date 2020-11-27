<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Newsletter;

class NewsletterController extends Controller {

	public function subscribe() {

		request()->validate([
			'email' => 'required|email',
			'type' => 'required|string',
		]);

		Newsletter::subscribe(request('email'), ['TYPE' => request('type')]);

		return response(['status' => 'success'], 200);

	}

	public function getMailingList() {

		$members = [];

		foreach (Newsletter::getMembers()['members'] as $member) {
			$user = \App\User::whereEmail($member['email_address'])->first();

			if ($user) {
				$type = $user->role;
			} else {
				$type = 'User';
			}

			if (request('filter_by')) {

				if (request('filter_by') == 'customer' and $type == 'customer') {

					array_push($members, ['email_address' => $member['email_address'], 'type' => $type]);

				} elseif (request('filter_by') == 'supplier' and $type == 'supplier') {

					array_push($members, ['email_address' => $member['email_address'], 'type' => $type]);

				} elseif (request('filter_by') == 'all') {
					array_push($members, ['email_address' => $member['email_address'], 'type' => $type]);
				}
			} else {

				array_push($members, ['email_address' => $member['email_address'], 'type' => $type]);

			}

		}

		return view('admin.maillinglist', ['members' => $members]);

	}

}
