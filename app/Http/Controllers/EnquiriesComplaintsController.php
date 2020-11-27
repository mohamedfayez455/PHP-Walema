<?php

namespace App\Http\Controllers;

use App\EnquiryComplaint;
use App\Http\Controllers\Controller;
use App\Mail\SendEnquiryComplaint;
use App\Supplier;
use App\User;
use Illuminate\Http\Request;
use Mail;

class EnquiriesComplaintsController extends Controller {

	public function upload_avatar($name, $value) {
		$class_name = explode('\\', get_class($value));

		$class = end($class_name);

		if ($class == 'UploadedFile') {

			$cont_avatar = json_decode(customer()->additional_data, true)['avatar'] ?? '';

			return upload([
				'file' => $name,
				'type' => 'single',
				'folder' => 'customers',
				'delete_file' => $cont_avatar,
			]);

		}
	}

	public function send($id) {
		$data = request()->validate([
			'email' => 'required|email',
			'name' => 'required|string|max:50',
			'type' => 'required|string',
			'message' => 'required|string',

		]);

		$add_data = request()->except(['email', '_token', 'name', 'type', 'message']);

		$additional_data = [];

		foreach ($add_data as $name => $value) {

			if (is_array($value)) {

				foreach ($value as $val) {

					if (is_object($val)) {

						$additional_data[$name] = $this->upload_avatar($name, $val);

					} else {

						$additional_data[$name] = $value;
					}

				}

			} else {
				if (is_object($value)) {

					$additional_data[$name] = $this->upload_avatar($name, $value);

				} else {

					$additional_data[$name] = $value;
				}

			}

		}

		$supplier = Supplier::find($id)->user;

		$add_data = ['sender_id' => customer()->user->id, 'reciever_id' => $supplier->id];

		$data = array_merge($data, $add_data);

		$additional_data = json_encode(($additional_data));

		$data = array_merge($data, ['additional_data' => $additional_data]);

		EnquiryComplaint::create($data);

		Mail::to($supplier->email)->send(new SendEnquiryComplaint($data));

		return response(['response' => 'send'], 200);

	}
}
