<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendQuickEmail;
use App\QuickEmail;
use App\Report;
use Illuminate\Http\Request;
use Mail;

class EmailController extends Controller {
	public function send_quick_emails() {

		$data = request()->validate([

			'email_to' => 'required|email',
			'subject' => 'required|string',
			'message' => 'required',

		]);

		Mail::to($data['email_to'])->send(new SendQuickEmail($data));

		QuickEmail::create($data);

		return response(['success'], 200);

	}

	public function get_reports() {

		$reports = Report::all();

		return view('admin.reports')->with('reports', $reports);

	}
}
