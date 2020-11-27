<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\DataTables\AdminDatatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller {
	public function index(AdminDatatable $adminDatatable) {

		return $adminDatatable->render('admin.admins.index', ['title' => 'Admins']);
	}

	public function create() {
		return view('admin.admins.create')->with('title', 'Create Admin');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {

		$data = request()->validate([

			'firstname' => 'required|string|min:3|max:15',

			'lastname' => 'required|string|min:3|max:15',

			'email' => ['required', 'email', 'unique:admins,email', 'regex:/(.+)@(gmail|yahoo|hotmail)\.com/i'],

			'password' => 'required|string|min:6|max:15',

			'photo' => 'sometimes|nullable|' . validate_image(),

		]);

		if (request()->hasFile('photo')) {

			$data['photo'] = upload([

				'file' => 'photo',
				'folder' => 'admins',
				'type' => 'single',

			]);
		}

		$data['password'] = bcrypt($data['password']);

		Admin::create($data);

		session()->flash('success', 'Admin Added Successfully');

		return redirect()->route('admins.create');

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$admin = Admin::find($id);

		return view('admin.admins.edit')->with(['admin' => $admin, 'title' => 'Edit Admin']);

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$admin = Admin::find($id);

		$data = request()->validate([

			'firstname' => 'required|string|min:3|max:15',

			'lastname' => 'required|string|min:3|max:15',

			'email' => ['required', 'email', 'unique:admins,email,' .
				$id],

			'photo' => 'sometimes|nullable|' . validate_image(),

		]);

		if (request()->hasFile('photo')) {

			$data['photo'] = upload([

				'file' => 'photo',
				'folder' => 'admins',
				'type' => 'single',
				'delete_file' => $admin->photo,

			]);

		} else {
			unset($data['photo']);
		}

		$admin->update($data);

		session()->flash('success', 'Admin Updated Successfully');

		return redirect()->route('admins.index');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroyAll() {
		if (request('items')) {

			foreach (request('items') as $id) {

				$admin = Admin::find($id);

				if ($admin->photo) {
					delete_file($admin->photo);
				}

				$admin->delete();
			}

			session()->flash('success', 'Admins Deleted Successfully');

		} else {
			session()->flash('error', 'Admins Can\'t Deleted Successfully');
		}

		return redirect()->route('admins.index');

	}

	public function destroy($id) {
		$admin = Admin::find($id);

		if ($admin->photo) {
			delete_file($admin->photo);
		}

		$admin->delete();

		session()->flash('success', 'Admin Deleted Successfully');

		return redirect()->route('admins.index');

	}
}
