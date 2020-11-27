<?php

namespace App\Http\Controllers;

use App\Friend;
use App\Http\Controllers\Controller;
use App\Message;
use App\User;
use Illuminate\Http\Request;
use Storage;

class MessagesController extends Controller {
	public function store() {

		$data = request()->validate([

			'sender_id' => 'required|numeric|exists:users,id',
			'reciever_id' => 'required|numeric|exists:users,id',
			'content' => 'required',
			'type' => 'required|in:message,file,image',

		]);

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

		return response($message, 200);

	}

	public function getMessage() {

		$data = request()->validate([

			'sender_id' => 'required|numeric|exists:users,id',
			'reciever_id' => 'required|numeric|exists:users,id',

		]);

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

		return response($messages, 200);

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

	public function get_full_chat_off() {

		$from_admin = false;

		if (request('sender_id')) {
			$from_admin = true;
			$user = request('sender_id');
		} else {

			$user = user()->id;

		}

		$messages = $this->chat_message($user, request('reciever_id'));

		$reciever = User::findOrFail(request('reciever_id'));

		return view('admin.message_history', compact('messages', 'from_admin', 'reciever', 'user'))->render();

	}

	public function chat_message($sender_id, $reciever_id) {
		$messages1 = collect(

			Message::where('sender_id', $sender_id)
				->where('reciever_id', $reciever_id)
				->orderBy('created_at', 'desc')->get()
		);

		$messages1 = $messages1->sortByDesc('created_at');

		$messages2 = collect(
			Message::where('sender_id', $reciever_id)
				->where('reciever_id', $sender_id)
				->orderBy('created_at', 'desc')->get()
		);

		$messages2 = $messages2->sortByDesc('created_at');

		$messages = $messages1->merge($messages2);

		$messages = $messages->toArray();

		$messages = $this->quick_sort($messages);

		return $messages;
	}

	private function upload($file, $folder, $image_name) {

		$img = Image::make($file);

		// now you are able to resize the instance

		$img->resize(700, 700, function ($constraint) {
			$constraint->aspectRatio();
		});

		$img->resize(700, 700);

		$image_path = public_path() . '/upload/' . $folder . '/' . $image_name;

		$img->save($image_path);

		return $image_name;

	}
}
