<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\DataTables\CustomerDatatable;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class CustomerController extends Controller {
	public function index(CustomerDatatable $customerDatatable) {
		return $customerDatatable->render('admin.customers.index', ['title' => 'customers']);
	}

	public function create() {
		return view('admin.customers.create')->with('title', 'Create Customer');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request, $flag = null) {

		$data = request()->validate([

			'firstname' => 'required|string|min:3|max:15',
			'lastname' => 'required|string|min:3|max:15',
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

		$additional_array = ['role' => 'customer'];

		if ($flag == null) {
			$additional_array = ['approved' => 1, "verified" => 1, 'role' => 'customer'];
		}

		$user = User::create(array_merge($additional_array, $data));

		Customer::create(['user_id' => $user->id]);

		if ($flag != null) {

			$user->token = str_random(30);
			$user->save();
			$user->sendVerificationEmail();
			return redirect()->route('login')->with('info', 'We sent you an activation code. Check your email and click on the link to verify.');
		}

		session()->flash('success', 'Customer Created Successfully');

		return redirect()->route('customers.create');

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
		$user = Customer::find($id)->user;

		return view('admin.customers.edit')->with(['user' => $user, 'title' => 'Edit Customer']);

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {

		$customer = Customer::find($id);

		$data = request()->validate([

			'firstname' => 'required|string|min:3|max:15',
			'lastname' => 'required|string|min:3|max:15',
			'email' => 'required|email|max:255|unique:users,email,' . $customer->user->id,
			'country_id' => 'required|exists:countries,id',
			'avatar' => 'sometimes|nullable|' . validate_image(),

		]);

		$user = $customer->user;

		if ($user) {

			if (request()->hasFile('avatar')) {

				$data['avatar'] = upload([

					'file' => 'avatar',
					'folder' => 'suppliers',
					'type' => 'single',

				]);
			}
			$user->update($data);

			session()->flash('success', 'Customer Updated Successfully');

		} else {

			session()->flash('error', 'Customer User Can Not Found');
		}

		return redirect()->route('customers.index');

	}

	public function destroyAll() {
		if (request('items')) {

			foreach (request('items') as $id) {

				$customer = Customer::find($id);
				$user = $customer->user;

				if ($user->avatar) {
					delete_file($user->avatar);
				}

				$customer->delete();
				$user->delete();

			}

			session()->flash('success', 'Customers Deleted Successfully');

		} else {
			session()->flash('error', 'Customers Can\'t Deleted Successfully');
		}

		return redirect()->route('customers.index');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$customer = Customer::find($id);
		$user = $customer->user;

		if ($user->avatar) {
			delete_file($user->avatar);
		}
		$customer->delete();
		$user->delete();

		session()->flash('success', 'Customer Deleted Successfully');

		return redirect()->route('customers.index');

	}
}
