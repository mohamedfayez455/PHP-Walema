<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendReport extends Mailable {
	use Queueable, SerializesModels;

	public $data = [];

	public function __construct($data) {
		$this->data = $data;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build() {
		return $this->markdown('admin.reports')
			->with('data', $this->data)
			->subject('Report');
	}
}
