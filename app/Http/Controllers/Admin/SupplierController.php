<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SupplierDatatable;
use App\Http\Controllers\Controller;
use App\Supplier;
use App\User;
use Illuminate\Http\Request;

class SupplierController extends Controller {
	public function index(SupplierDatatable $supplierDatatable) {

		return $supplierDatatable->render('admin.suppliers.index', ['title' => 'suppliers']);
	}

	public function create() {
		return view('admin.suppliers.create')->with('title', 'Create Supplier');
	}

	public function chat_history($id) {
		$user = User::findOrFail($id);
		$title = $user->email . ' Chat History';

		return view('admin.chat_history', compact('user', 'title'));

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request, $flag = null) {

		$data = request()->validate([

			'firstname' => 'required|string|min:3|max:1515',
			'lastname' => 'required|string|min:3|max:1515',
			'email' => 'required|email|max:255|unique:users,email',
			'password' => 'required|string|max:20|min:6',
			'country_id' => 'required|exists:countries,id',
			'avatar' => 'sometimes|nullable|' . validate_image(),

		]);

		$data['password'] = bcrypt($data['password']);

		if (request()->hasFile('avatar')) {

			$data['avatar'] = upload([

				'file' => 'avatar',
				'folder' => 'suppliers',
				'type' => 'single',

			]);
		}

		$additional_array = ['role' => 'supplier'];

		if ($flag == null) {
			$additional_array = ['approved' => 1, "verified" => 1, 'role' => 'supplier'];
		}

		$user = User::create(array_merge($data, $additional_array));

		$user->token = str_random(30);
		$user->save();
		$user->sendVerificationEmail();

		$supplier = Supplier::create(['user_id' => $user->id]);

		if ($flag != null) {

			$user->token = str_random(30);
			$user->save();
			$user->sendVerificationEmail();

			return redirect()->route('login')->with('info', 'We sent you an activation code. Check your email and click on the link to verify.');

		}

		session()->flash('success', 'Supplier Added Successfully');

		return redirect()->route('suppliers.create');

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
		$user = Supplier::find($id)->user;

		return view('admin.suppliers.edit')->with([
			'user' => $user,
			'title' => 'Edit Supplier',
		]);

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$supplier = Supplier::find($id);

		$data = request()->validate([

			'firstname' => 'required|string|min:3|max:15',
			'lastname' => 'required|string|min:3|max:15',
			'email' => 'required|email|max:255|unique:users,email,' . $supplier->user->id,
			'country_id' => 'required|exists:countries,id',
			'avatar' => 'sometimes|nullable|' . validate_image(),
		]);

		$user = $supplier->user;

		if ($user) {

			if (request()->hasFile('avatar')) {

				$data['avatar'] = upload([

					'file' => 'avatar',
					'folder' => 'suppliers',
					'type' => 'single',

				]);
			}
			$user->update($data);

			session()->flash('success', 'Supplier Updated Successfully');

		} else {

			session()->flash('error', 'Supplier User Can Not Found');
		}

		return redirect()->route('suppliers.index');

	}

	public function destroyAll() {
		if (request('items')) {

			foreach (request('items') as $id) {

				$supplier = Supplier::find($id);
				$user = $supplier->user;

				if ($user->avatar) {
					delete_file($user->avatar);
				}
				$supplier->delete();

				$user->delete();
			}

			session()->flash('success', 'Suppliers Deleted Successfully');

		} else {
			session()->flash('error', 'Suppliers Can\'t Deleted Successfully');
		}

		return redirect()->route('suppliers.index');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$supplier = Supplier::find($id);

		$user = $supplier->user;

		if ($user->avatar) {
			delete_file($user->avatar);
		}
		$supplier->delete();

		$user->delete();

		session()->flash('success', 'Supplier Deleted Successfully');

		return redirect()->route('suppliers.index');

	}
}
