<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\InputFields;
use App\SupplierProfileInputChildrens;
use App\SuppliersProfileFormInput;
use App\SuppliersProfileFormInputAttribute;
use Illuminate\Http\Request;

class SuppliersProfileBuilderController extends Controller {
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

			$inputsOfSuppliersWithAttribute = SuppliersProfileFormInput::inputsOfSuppliersWithAttribute(request('page'));

			$inputsWithAttribute = $inputsOfSuppliersWithAttribute[0];

			$ids = $inputsOfSuppliersWithAttribute[1];

			$types = $inputsOfSuppliersWithAttribute[2];

			$values = $inputsOfSuppliersWithAttribute[3];

			return response([$inputsWithAttribute, $ids, $types, $values], 200);

		}
	}

	public function getInputAttributeWithValue() {
		if (request()->ajax()) {

			if (request('input_id')) {

				$InputAttributs = SuppliersProfileFormInput::findInputAttributs(request('input_id'));

				$attributes = $InputAttributs[0];
				$published_on_profile = $InputAttributs[1];
				$published_on_signup = $InputAttributs[2];

				$childrens = SuppliersProfileFormInput::findInputChildrens(request('input_id'));

				if ($childrens) {

					$attributes = array_merge($attributes, $childrens);
				}

				return response()->json([$attributes, $published_on_profile, $published_on_signup]);
			}

		}
	}

	public function getInputAttribute() {

		$add_array['current_url'] = \URL::Current();

		if (request()->ajax()) {

			if (request('input_id')) {

				$attributes = InputFields::findInputAttributs(request('input_id'));

				$childs = InputFields::findInputChildrens(request('input_id'));

				if ($childs) {

					$attributes = array_merge($attributes, $childs);
				}

				return response()->json($attributes);
			}

		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {

		SuppliersProfileFormInput::validate_attribute();

		SuppliersProfileFormInput::createInput($request, request('input_id'));

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
		$inputsOfSuppliersWithAttribute = SuppliersProfileFormInput::inputsOfSuppliersWithAttribute();

		$inputsWithAttribute = $inputsOfSuppliersWithAttribute[0];

		$ids = $inputsOfSuppliersWithAttribute[1];

		$inputs = InputFields::pluckNameWithIdFromInputField();

		$url = url('admin/suppliers_profile_builder');

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

		SuppliersProfileFormInput::validate_attribute('update');

		$this->destroy($id, false);

		SuppliersProfileFormInput::updateInput($request, $id);
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

		$SupplierField = SuppliersProfileFormInput::find($id);

		if ($SupplierField) {

			if ($flag) {

				$SupplierField->delete();

			}

			$attributes = SuppliersProfileFormInputAttribute::where('input_id', $id)->get();

			foreach ($attributes as $attribute) {

				$attribute->delete();

			}

			$childs = SupplierProfileInputChildrens::where('supplier_input_id', $id)->get();

			foreach ($childs as $child) {
				$child->delete();
			}

			if ($flag) {

				return back()->with('success', 'Field Deleted');

			}

			return;

		} else {
			return back()->with('error', 'Field Not Found');
		}
	}
}
