<?php

namespace App\Http\Controllers;

use App\ContactUs;
use App\Http\Controllers\Controller;
use App\Mail\ContactUs as ContactUsMail;
use App\User;
use Illuminate\Http\Request;
use Mail;

class ContactUsController extends Controller {
	public function send() {
		$data = request()->validate([

			'subject' => 'required|string',
			'email' => 'required|email',
			'name' => 'required|string|max:50',
			'content' => 'required|string',

		]);

		Mail::to('info@walema.com')->send(new ContactUsMail([
			'email' => request('email'),
			'subject' => request('subject'),
			'name' => request('name'),
			'content' => request('content'),
		]));

//		$sender_id = User::whereEmail(request('email'))->first()->id;

//		$add_data = ['sender_id' => $sender_id];

//		$data = array_merge($data, $add_data);

		ContactUs::create($data);

		return back()->with('success', 'Please Wait For Respond');

	}
}
