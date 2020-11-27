<?php

namespace App\Http\Controllers;

use App\File;
use Storage;

class Upload {

	public static function upload($data) {

		if (request()->hasFile($data['file']) and $data['type'] == 'single') {

			if (array_key_exists('delete_file', $data) && $data['delete_file'] && $data['delete_file'] != []) {

				self::delete_file($data['delete_file']);

			}

			$uploaded_file = request()->file($data['file']);

			if (is_array($uploaded_file)) {

				foreach ($uploaded_file as $file) {
					$uploaded_file = $file->store($data['folder']);
				}

				return $uploaded_file;
			}

			return $uploaded_file->store($data['folder']);

		} elseif (request()->hasFile($data['file']) and $data['type'] == 'files') {

			$file = request()->file($data['file']);

			$file->store($data['folder']);

			$file = File::create([

				'name' => $file->getClientOriginalName(),
				'size' => $file->getSize(),
				'file' => $file->hashName(),
				'path' => $data['folder'],
				'full_path' => $data['folder'] . '/' . $file->hashName(),
				'mime_type' => $file->getMimeType(),
				'file_type' => $data['file_type'],
				'relation_id' => $data['relation_id'],

			]);

			return $file->id;

		}
	}

	public static function delete_file($data) {

		if (!str_contains($data, 'default')) {
			Storage::has($data) ? Storage::delete($data) : '';
		}

	}

	public static function delete($id) {

		$file = File::find($id);

		if ($file) {

			self::delete_file($file->full_path);
			$file->delete();

		}

	}
}