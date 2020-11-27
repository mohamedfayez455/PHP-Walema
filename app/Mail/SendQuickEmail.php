<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendQuickEmail extends Mailable {
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
		return $this->markdown('admin.quick_emails')
			->with('data', $this->data)
			->subject('Quick Email');
	}
}
