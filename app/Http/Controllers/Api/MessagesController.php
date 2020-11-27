<?php

namespace App\Http\Controllers\Api;

use App\Friend;
use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;
use Storage;
use Validator;

class MessagesController extends Controller {

	use ApiResponse;

	public function store() {

		$data = request()->all();

		$validator = Validator::make($data, [
			'sender_id' => 'required|numeric|exists:users,id',
			'reciever_id' => 'required|numeric|exists:users,id',
			'content' => 'required',
			'type' => 'required|in:message,file,image',
		]);

		if ($validator->fails()) {
			return $this->apiResponse(null, $validator->errors());
		}

		if ($data['type'] != 'message') {
			$content = $data['content'];
			$data['content'] = 'content';
		}

		$message = Message::create($data);

		if (in_array($data['type'], ['file', 'image'])) {

			$file = explode(',', $content);

			$content = $file[1];

			$ext = explode(';', explode('/', $file[0])[1])[0];

			$content = base64_decode($content);

			$path = 'chat/' . $message->id . '.' . $ext;

			Storage::put($path, $content);

			$message->update(['content' => $path]);
		}

		$exist1 = Friend::where(['customer_id' => request('sender_id'), 'supplier_id' => request('reciever_id')])->exists();

		$exist2 = Friend::where(['customer_id' => request('reciever_id'), 'supplier_id' => request('sender_id')])->exists();

		if (!($exist1 || $exist2)) {

			if (is_customer()) {

				Friend::create(['customer_id' => customer()->user->id, 'supplier_id' => request('reciever_id')]);

			} else {

				Friend::create(['customer_id' => request('reciever_id'), 'supplier_id' => supplier()->user->id]);
			}
		}

		return $this->successResponse($message);

	}

	public function getMessage() {

		$data = request()->all();

		$validator = Validator::make($data, [
			'sender_id' => 'required|numeric|exists:users,id',
			'reciever_id' => 'required|numeric|exists:users,id',
		]);

		if ($validator->fails()) {
			return $this->apiResponse(null, $validator->errors());
		}

		$messages1 = collect(Message::where('sender_id', $data['sender_id'])
				->where('reciever_id', $data['reciever_id'])
				->orderBy('created_at', 'desc')->get());
		$messages1 = $messages1->sortByDesc('created_at');

		$messages2 = collect(Message::where('sender_id', $data['reciever_id'])
				->where('reciever_id', $data['sender_id'])
				->orderBy('created_at', 'desc')->get());

		$messages2 = $messages2->sortByDesc('created_at');

		$messages = $messages1->merge($messages2);

		$messages = $messages->toArray();

		$messages = $this->quick_sort($messages);

		return $this->successResponse($message);

	}

	public function quick_sort($my_array) {

		$loe = $gt = [];

		if (count($my_array) < 2) {
			return $my_array;
		}
		$pivot_key = key($my_array);
		$pivot = array_shift($my_array);
		foreach ($my_array as $val) {
			if ($val <= $pivot) {
				$loe[] = $val;
			} elseif ($val > $pivot) {
				$gt[] = $val;
			}
		}

		return array_merge($this->quick_sort($loe), array($pivot_key => $pivot), $this->quick_sort($gt));
	}
}
