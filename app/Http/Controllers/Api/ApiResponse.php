<?php

namespace App\Http\Controllers\Api;
use App\Models\User;

trait ApiResponse {

	public $resource_namespace = "\App\Http\Resources\\";

	public function apiResponse($data = null, $message = '', $code = 200) {

		if (is_object($message)) {
			$message = is_array($message->getMessages()) ? head($message->getMessages())[0] : $message;
		}

		$code = in_array($code, $this->successCodes()) ? 200 : $code;

		$status = $data ? true : false;

		return response(compact('data', 'status', 'message'), $code);

	}

	public function file_response($file) {

		return response()->file($file);

	}

	public function successResponse($data = null, $message = '') {

		$status = true;

		return response(compact('data', 'status', 'message'));

	}

	public function failedResponse($data = null, $message = '', $code = 200) {

		if (is_object($message)) {

			$message = is_array($message->getMessages()) ? head($message->getMessages())[0] : $message;

		}

		$status = false;

		return response(compact('data', 'status', 'message'), $code);

	}

	public function unauthenticated() {
		$message = 'UnAuthinticated';

		return $this->apiResponse(null, $message, 403);

	}

	public function successCodes() {
		return [200, 201, 202, 302];
	}

	public function failedCodes() {
		return [403, 404, 422];
	}

	public function notFound() {
		return $this->apiResponse(null, 'Not Found', 200);
	}

	public function collection($resource, $collection, $flag = true) {

		$resource = $this->resource_namespace . $resource;

		$collection = $resource::collection($collection);

		return $flag ? $this->apiResponse(!$collection->isEmpty() ? $collection : null, '') : $collection;

	}

	public function collections($collections) {

		foreach ($collections as $resource => $collection):

			$data[array_keys($collection)[0]] = $this->collection($resource, array_values($collection)[0], false);

		endforeach;

		return $this->apiResponse($data, '', 200);

	}

	public function single_row($resource, $row, $message = '', $code = 200) {

		if ($row) {

			$resource = $this->resource_namespace . $resource;

			$row = new $resource($row);

			return $this->apiResponse($row, $message, $code);
		}

		return $this->notFound();

	}

	public function api_user() {
		return auth('api')->user();
	}

	public function api_user_id() {
		return auth('api')->id();
	}

	public function api_user_with_default() {

		if (auth('api')->check()) {
			return auth('api')->user();
		}

		return new User;

	}

	public function api_admin() {
		return auth('admin')->user();
	}
}
