<?php

namespace App\Http\Controllers\Admin;

use App\CustomerProfileInputChildrens;
use App\CustomersProfileFormInput;
use App\CustomersProfileFormsInputAttribute;
use App\Http\Controllers\Controller;
use App\InputFields;
use Illuminate\Http\Request;

class CustomersProfileBuilderController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {

		$inputs = InputFields::pluckNameWithIdFromInputField();

		return view('admin/form_builder/index', compact('inputs'));
	}

	public function getProfileBuilder() {

		if (request()->ajax()) {

			$inputsOfCustomersWithAttribute = CustomersProfileFormInput::inputsOfCustomersWithAttribute(request('page'));

			$inputsWithAttribute = $inputsOfCustomersWithAttribute[0];

			$ids = $inputsOfCustomersWithAttribute[1];

			$types = $inputsOfCustomersWithAttribute[2];

			$values = $inputsOfCustomersWithAttribute[3];

			return response([$inputsWithAttribute, $ids, $types, $values], 200);

		}

	}

	public function getInputAttribute() {

		if (request()->ajax()) {

			if (request('input_id')) {

				$attributes = InputFields::findInputAttributs(request('input_id'));

				$attributes2 = InputFields::findInputChildrens(request('input_id'));

				if ($attributes2) {

					$attributes = array_merge($attributes, $attributes2);
				}

				return response()->json($attributes);
			}

		}
	}

	public function getInputAttributeWithValue() {
		if (request()->ajax()) {

			if (request('input_id')) {

				$InputAttributs = CustomersProfileFormInput::findInputAttributs(request('input_id'));

				$attributes = $InputAttributs[0];
				$published_on_profile = $InputAttributs[1];
				$published_on_signup = $InputAttributs[2];

				$childs = CustomersProfileFormInput::findInputChildrens(request('input_id'));

				if ($childs) {

					$attributes = array_merge($attributes, $childs);
				}

				return response()->json([$attributes, $published_on_profile, $published_on_signup]);
			}

		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {

		CustomersProfileFormInput::validate_attribute();

		CustomersProfileFormInput::createInput($request, request('input_id'));

		request()->flush();

		return back()->with('success', 'Input Inserted Successfully');
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
	public function editFormBuilder() {

		$inputsOfCustomersWithAttribute = CustomersProfileFormInput::inputsOfCustomersWithAttribute();

		$inputsWithAttribute = $inputsOfCustomersWithAttribute[0];

		$inputs = InputFields::pluckNameWithIdFromInputField();

		$ids = $inputsOfCustomersWithAttribute[1];

		$types = $inputsOfCustomersWithAttribute[2];

		$url = url('admin/customers_profile_builder');

		return view('admin.form_builder.edit_form_builder', compact('url', 'inputs', 'inputsWithAttribute', 'ids'));

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function update(Request $request, $id) {

		CustomersProfileFormInput::validate_attribute('update');

		$this->destroy($id, false);
		CustomersProfileFormInput::updateInput($request, $id);
		request()->flush();

		return back()->with('success', 'Field Updated');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id, $flag = true) {
		$customerField = CustomersProfileFormInput::find($id);

		if ($customerField) {

			if ($flag) {

				$customerField->delete();
			}

			$attributes = CustomersProfileFormsInputAttribute::where('input_id', $id)->get();

			foreach ($attributes as $attribute) {

				$attribute->delete();

			}

			$childrens = CustomerProfileInputChildrens::where('customer_input_id', $id)->get();

			foreach ($childrens as $child) {
				$child->delete();
			}

			if ($flag) {

				return back()->with('success', 'Field Deleted');

			}
			$input_id = $customerField->input_id;

			return;

		}

		return back()->with('error', 'Field Not Found');
	}
}
