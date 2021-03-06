<?php

namespace App;

use App\Attributes;
use App\InputFields;
use App\SupplierProfileInputChildrens;
use App\SuppliersProfileFormInputAttribute;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SuppliersProfileFormInput extends Model {

	protected $table = "suppliers_profile_forms";

	protected $fillable = ['input_id', 'published_on_profile', 'published_on_signup'];

	public function input() {
		return $this->hasOne('App\InputFields', 'id', 'input_id');
	}

	public function InputAttributes() {
		return $this->hasMany('App\SuppliersProfileFormInputAttribute', 'input_id', 'id');
	}

	public function childrens() {
		return $this->hasMany('App\SupplierProfileInputChildrens', 'supplier_input_id', 'id');
	}

	public static function validate_item() {

		foreach (request()->all() as $attr => $val) {

			if (preg_match('/^item[0-9]$/i', $attr)) {
				request()->validate([
					$attr => 'required|string|max:30',
				]);
			}

		}
	}

	public static function validate_option() {

		$name = request('name');

		foreach (request()->all() as $attr => $val) {

			if (preg_match('/^option[0-9]$/i', $attr) and !array_key_exists($name, ['categories_id', 'types_id'])) {
				request()->validate([
					$attr => 'required|string|max:30',
				]);
			} elseif (array_key_exists($name, ['categories_id', 'types_id'])) {
				request()->validate([
					$attr => 'sometimes|nullable|string|max:30',
				]);
			}

		}
	}

	public static function validate_attribute($flag = null) {

		$field = InputFields::find(request('input_id'));

		if ($field) {

			$type = $field->type;

			if ($flag == 'update') {

				request()->validate([

					'name' => 'required|alpha_dash|max:25',
				]);

			} else {

				request()->validate([

					'name' => 'required|alpha_dash|max:25|unique:suppliers_profile_form_input_attributes,value',
				]);
			}

			request()->validate([

				'guide' => 'sometimes|nullable|string|max:30',
				'id_attr' => 'sometimes|nullable|alpha_dash|max:25',
			]);

			if ($type == 'email' || $type == 'text' || $type == 'tel' || $type == 'number' || $type == 'range' || $type == 'password' || $type == 'url') {

				request()->validate([
					'labelAttr' => 'required|string|max:25',
					'value' => 'sometimes|nullable|string|max:25',
					'required' => 'sometimes|nullable|in:on',
					'placeholder' => 'required|string|max:25',
					'maxlength' => 'sometimes|nullable',

				]);
			}

			if ($type == 'textarea') {

				request()->validate([
					'labelAttr' => 'required|string|max:25',
					'value' => 'sometimes|nullable|string|max:25',
					'required' => 'sometimes|nullable|in:on',
					'maxlength' => 'sometimes|nullable',

				]);
			}

			if ($type == 'dropdown') {

				self::validate_item();

			}if ($type == 'select') {

				self::validate_option();

				request()->validate([
					'labelAttr' => 'required|string|max:25',
					'multiple' => 'sometimes|nullable|string|max:25|in:on',

				]);
			}

			if ($type == 'text' || $type == 'tel') {

				request()->validate([
					'size' => 'sometimes|nullable|string|max:25',
				]);
			}

			if ($type == 'number' || $type == 'range') {

				request()->validate([
					'min' => 'sometimes|nullable|numeric',
					'max' => 'sometimes|nullable|numeric',

				]);
			}

			if ($type == 'range') {

				request()->validate([
					'step' => 'sometimes|nullable|numeric',
				]);
			}

			if ($type == 'password') {

				request()->validate([
					'is_confirm' => 'sometimes|nullable|in:on',
				]);
			}

			if ($type == 'radio' || $type == 'checkbox') {

				request()->validate([
					'labelAttr' => 'required|string|max:25',
					'value' => 'required|string|max:25',

				]);
			}

			if ($type == 'file') {

				request()->validate([
					'labelAttr' => 'required|string|max:25',
					'required' => 'sometimes|nullable|in:on',
					'multiple' => 'sometimes|nullable|in:on',
					'accept' => 'sometimes|nullable|string',

				]);
			}

		}

	}

	public static function createInput($request, $input_id) {

		self::validate_attribute();

		$published_on_profile = request('published_on_profile') ? true : false;
		$published_on_signup = request('published_on_signup') ? true : false;

		$supplierInput = SuppliersProfileFormInput::create([
			'input_id' => $input_id,
			'published_on_profile' => $published_on_profile,
			'published_on_signup' => $published_on_signup,
		]);

		$request = $request->except(['input_id', '_token', 'published_on_profile', 'published_on_signup', '_method']);

		$anotherInputAttr = [];

		foreach ($request as $key => $value) {

			$attribute = Attributes::where('attribute', $key)->first();

			$attribute_id = $attribute->id ?? NULL;

			if ($value) {

				if (!$attribute_id) {

					if (preg_match('/^item[0-9]$/i', $key) || preg_match('/^option[0-9]$/i', $key)) {

						$key = preg_split('/[1-9]+/', $key)[0];

						$input = InputFields::where('type', $key)->first();

						$input_id = $input->id ?? NULL;

						if ($input_id) {

							SupplierProfileInputChildrens::create([

								'supplier_input_id' => $supplierInput->id,
								'input_id' => $input_id,
								'name' => ucfirst($value),
								'value' => $value,
							]);

						}

					} else {

						$anotherInputAttr[$key] = $value;
					}

				} else {

					if ($supplierInput->input->type == 'checkbox' and $key == 'name') {

						if (stripos($value, '[]') < 1) {
							$value .= '[]';
						}

					}

					SuppliersProfileFormInputAttribute::create([

						'input_id' => $supplierInput->id,
						'attr_id' => $attribute_id,
						'value' => $value,

					]);

				}

			}

		}

		if ($anotherInputAttr != []) {

			self::addAnotherField($anotherInputAttr, $input_id, $published_on_profile, $published_on_signup);

		}

	}

	public static function updateInput($request, $supplier_input_id) {

		self::validate_attribute();

		$supplierInput = SuppliersProfileFormInput::find($supplier_input_id);

		if ($supplierInput) {

			$published_on_profile = request('published_on_profile') ? true : false;
			$published_on_signup = request('published_on_signup') ? true : false;

			$supplierInput->update([
				'published_on_profile' => $published_on_profile,
				'published_on_signup' => $published_on_signup,
			]);

			$anotherInputAttr = [];

			$request = $request->except(['input_id', '_token', 'published_on_profile', 'published_on_signup', '_method']);

			foreach ($request as $key => $value) {

				$attribute = Attributes::where('attribute', $key)->first();

				$attribute_id = $attribute->id ?? NULL;

				if ($value) {

					if (!$attribute_id) {

						if (preg_match('/^item[0-9]$/i', $key) || preg_match('/^option[0-9]$/i', $key)) {

							$key = preg_split('/[1-9]+/', $key)[0];

							$input = InputFields::where('type', $key)->first();

							$input_id = $input->id ?? NULL;

							if ($input_id) {

								SupplierProfileInputChildrens::create([

									'supplier_input_id' => $supplierInput->id,
									'input_id' => $input_id,
									'name' => ucfirst($value),
									'value' => $value,
								]);

							}

						} else {

							$anotherInputAttr[$key] = $value;
						}

					} else {

						if ($supplierInput->input->type == 'checkbox' and $key == 'name') {

							if (stripos($value, '[]') < 1) {
								$value .= '[]';
							}

						}

						SuppliersProfileFormInputAttribute::create([

							'input_id' => $supplierInput->id,
							'attr_id' => $attribute_id,
							'value' => $value,

						]);

					}

				}

			}

			if ($anotherInputAttr != []) {

				self::addAnotherField($anotherInputAttr, $supplierInput->input_id, $published_on_profile, $published_on_signup);

			}
		} else {
			return back()->with('error', ' This Input Can\'t Be Updated ');
		}

	}

	public static function addAnotherField($anotherInputAttr, $input_id, $published_on_profile, $published_on_signup) {

		$supplierInput = SuppliersProfileFormInput::create([
			'input_id' => $input_id,
			'published_on_profile' => $published_on_profile,
			'published_on_signup' => $published_on_signup,
		]);

		foreach ($anotherInputAttr as $key => $value) {

			$key = explode('_', $key);

			$key = end($key);

			$attribute = Attributes::where('attribute', $key)->first();

			$attribute_id = $attribute->id ?? NULL;

			if ($attribute_id) {
				SuppliersProfileFormInputAttribute::create([

					'input_id' => $supplierInput->id,
					'attr_id' => $attribute_id,
					'value' => $value,

				]);
			}

		}

	}

	public static function inputsOfSuppliersWithAttribute($page = null) {

		if ($page == 'signup') {
			$key = 'published_on_signup';
		} else {
			$key = 'published_on_profile';
		}

		if ($page == null) {
			$inputs = SuppliersProfileFormInput::all();
		} else {
			$inputs = SuppliersProfileFormInput::where($key, 1)->get();
		}

		$inputsWithAttribute = [];
		$ids = [];
		$types = [];
		$values = [];

		foreach ($inputs as $input) {

			$name = '';
			$AttributesOfInputs = [];

			$childrens = $input->childrens;

			foreach ($childrens as $child) {

				$key = $child->input->name;
				$value = $child->value;
				$name = $child->name;

				$value = '(' . $key . ') ' . $name . ': ' . $value;

				$AttributesOfInputs[] = $value;
			}

			$attributes = $input->InputAttributes;

			foreach ($attributes as $attribute) {

				$Attribute = $attribute->Attribute;

				$Attribute->attribute = preg_split('/[A-Z]/', $Attribute->attribute)[0];

				$AttributeArray = explode('_', $Attribute->attribute);

				$AttributeName = '';

				for ($i = 0; $i < count($AttributeArray); $i++) {
					$AttributeName .= ' ' . $AttributeArray[$i];
				}

				$value = $AttributeName . ': ' . $attribute->value;

				if ($Attribute->attribute == 'name') {
					$name = $attribute->value;
				}

				$AttributesOfInputs[] = $value;

			}

			$ids[] = $input->id;

			$name = explode('[]', $name)[0];
			$types[] = $input->input->type;

			if ($input->input->type == 'checkbox' || $input->input->type == 'radio') {

				$name .= random_int(1, 20);

				if (isset($inputsWithAttribute[$name])) {

					$oldValue = $inputsWithAttribute[$name];
					$oldName = $name;

					$inputsWithAttribute[$oldName] = $oldValue;

					$name .= random_int(1, 100);

				}

			}

			$inputsWithAttribute[$name] = $AttributesOfInputs;

		}

		if ($page == 'edit_profile') {

			$user = supplier()->user->toArray();
			$supplier = supplier()->toArray();

			$userAttribute = array_keys($user);
			$suppAttribute = array_keys(supplier()->toArray());

			foreach ($userAttribute as $attribute) {

				$values[$attribute] = $user[$attribute];

			}

			foreach ($suppAttribute as $attribute) {

				if ($attribute == 'additional_data') {
					continue;
				}

				$values[$attribute] = $supplier[$attribute];

			}

			$additional_data = supplier()->toArray()['additional_data'] ?: [];

			foreach ($additional_data as $data => $value) {

				$values[$data] = $value;

			}
		}

		return [$inputsWithAttribute, $ids, $types, $values];

	}

	public static function findInputAttributs($input_id) {

		$supplierInput = SuppliersProfileFormInput::where('id', $input_id)->first();

		$attributes = InputFields::findInputAttributs($supplierInput->input_id);

		$supplierInputAttributes = $supplierInput->InputAttributes;

		$attributesArray = [];

		foreach ($attributes as $attribute) {

			$attribute['value'] = '';

			foreach ($supplierInputAttributes as $supplierInputAttribute) {

				if ($attribute['attribute'] == $supplierInputAttribute->attribute->attribute) {

					$attribute['value'] = explode('[]', $supplierInputAttribute->value)[0];

				}

			}

			$input_id = $supplierInput->input_id;

			$Supplierinputs = SuppliersProfileFormInput::where('input_id', $input_id)->get()->toArray();
			$number = count($Supplierinputs);

			if ($number == 2 and $attribute['attribute'] == 'is_confirm' and $attribute['value'] == 'on') {
				continue;
			}

			$supplierInputExistsMoreOne = false;

			foreach ($Supplierinputs as $input) {

				if ($input['id'] == $supplierInput->id) {

					$supplierInputExistsMoreOne = true;
					break;
				}
			}

			if ($number == 2 and $supplierInputExistsMoreOne and $attribute['attribute'] == 'is_confirm') {
				continue;
			}

			$attributesArray[] = $attribute;

		}

		return [$attributesArray, $supplierInput->published_on_profile, $supplierInput->published_on_signup];
	}

	public static function findInputChildrens($input_id) {

		$supplierInput = SuppliersProfileFormInput::where('id', $input_id)->first();

		$childrens = InputFields::findInputChildrens($supplierInput->input_id);

		$supplierInputChildrens = $supplierInput->childrens->toArray();

		$childrensArray = [];

		foreach ($childrens as $child) {

			foreach ($supplierInputChildrens as $supplierInputChild) {

				$supplierInputChild['type'] = $child['type'];
				$supplierInputChild['name'] = $child['name'];

				$childrensArray[] = $supplierInputChild;

			}

		}

		return $childrensArray;
	}

}
