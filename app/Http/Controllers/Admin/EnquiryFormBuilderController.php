<?php

namespace App\Http\Controllers\Admin;

use App\EnquiryFormBuilderInput;
use App\EnquiryFormBuilderInputAttribute;
use App\EnquiryFormBuilderInputChildrens;
use App\Http\Controllers\Controller;
use App\InputFields;
use Illuminate\Http\Request;

class EnquiryFormBuilderController extends Controller {
	public function index() {

		$inputs = InputFields::pluckNameWithIdFromInputField();

		return view('admin/form_builder/index', compact('inputs'));
	}

	public function getProfileBuilder() {

		if (request()->ajax()) {

			$inputsOfEnquiryWithAttribute = EnquiryFormBuilderInput::inputsOfEnquiryWithAttribute(request('page'));

			$inputsWithAttribute = $inputsOfEnquiryWithAttribute[0];

			$ids = $inputsOfEnquiryWithAttribute[1];

			$types = $inputsOfEnquiryWithAttribute[2];

			$values = $inputsOfEnquiryWithAttribute[3];

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

				$InputAttributs = EnquiryFormBuilderInput::findInputAttributs(request('input_id'));

				$attributes = $InputAttributs[0];
				$publish = $InputAttributs[1];

				$childs = EnquiryFormBuilderInput::findInputChildrens(request('input_id'));

				if ($childs) {

					$attributes = array_merge($attributes, $childs);
				}

				return response()->json([$attributes, $publish, '']);
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

		EnquiryFormBuilderInput::validate_attribute();

		EnquiryFormBuilderInput::createInput($request, request('input_id'));

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

		$inputsOfEnquiryWithAttribute = EnquiryFormBuilderInput::inputsOfEnquiryWithAttribute();

		$inputsWithAttribute = $inputsOfEnquiryWithAttribute[0];

		$inputs = InputFields::pluckNameWithIdFromInputField();

		$ids = $inputsOfEnquiryWithAttribute[1];

		$types = $inputsOfEnquiryWithAttribute[2];

		$url = url('admin/enquiry_form_builder');

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

		EnquiryFormBuilderInput::validate_attribute('update');

		$this->destroy($id, false);

		EnquiryFormBuilderInput::updateInput($request, $id);

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
		$enquiryField = EnquiryFormBuilderInput::find($id);

		if ($enquiryField) {

			if ($flag) {

				$enquiryField->delete();
			}

			$attributes = EnquiryFormBuilderInputAttribute::where('input_id', $id)->get();

			foreach ($attributes as $attribute) {

				$attribute->delete();

			}

			$childrens = EnquiryFormBuilderInputChildrens::where('enquiry_input_id', $id)->get();

			foreach ($childrens as $child) {
				$child->delete();
			}

			if ($flag) {

				return back()->with('success', 'Field Deleted');

			}
			$input_id = $enquiryField->input_id;

			return;

		}

		return back()->with('error', 'Field Not Found');
	}
}
