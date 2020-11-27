<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Setting;
use DB;
use Illuminate\Http\Request;

class SettingController extends Controller {
	public function index() {
		$setting = Setting::first();

		return view('admin.settings.index')->with(['title' => 'App Settings', 'setting' => $setting]);
	}

	public function update() {

		$setting = Setting::first();

		$data = request()->validate([

			"app_name" => "required|string|min:3|max:50",
			"email" => "required|email",
			"description" => "sometimes|nullable|min:10|max:255",
			"status" => "required|in:close,open",
			"message_maintenance" => "sometimes|nullable|min:10|max:255",
			"icon" => "sometimes|nullable|" . validate_image(),

		]);

		if (request()->hasFile('icon')) {

			$data['icon'] = upload([

				'type' => 'single',
				'file' => 'icon',
				'folder' => 'settings',
				'delete_file' => $setting->icon,

			]);

		}

		$setting->update($data);

		return redirect()->route('settings.index')->with('success', 'Settings Updated');
	}

	public function supplier_advanced_search() {

		$record = DB::table('advanced_search')->first();

		return view('admin.settings.supplier_advanced_search')->with(['title' => 'supplier Advanced Filter', 'record' => $record]);
	}

	public function do_supplier_advanced_search() {

		$data["search_with_category"] = request("search_with_category") ?: '';
		$data["search_with_sub_category"] = request("search_with_sub_category") ?: '';
		$data["search_with_type"] = request("search_with_type") ?: '';

		$record = DB::table('advanced_search')->first();

		if ($record) {

			DB::table('advanced_search')->where('id', $record->id)->update($data);

		} else {
			DB::table('advanced_search')->insert($data);
		}

		return back()->with('success', 'Advanced Filter Updated');

	}
}
