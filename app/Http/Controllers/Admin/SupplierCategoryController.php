<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupplierCategoryController extends Controller {
	public function index() {
		return view('admin.supplier-categories.index', ['title' => 'supplier-categories']);
	}

	public function create() {
		return view('admin.supplier-categories.create')->with('title', 'Create Supplier Category');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {

		$data = request()->validate([

			'name' => 'required|string|min:3|max:30',

			'desc' => 'required|string|min:3|max:255',

			'parent_id' => 'sometimes|nullable|numeric',

			'photo' => 'sometimes|nullable|' . validate_image(),

		]);

		if (request()->hasFile('photo')) {

			$data['photo'] = upload([

				'file' => 'photo',
				'folder' => 'categories',
				'type' => 'single',

			]);
		}

		Category::create($data);

		session()->flash('success', 'Supplier Category Added Successfully');

		return redirect()->route('supplier-categories.create');

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
		$category = Category::find($id);

		return view('admin.supplier-categories.edit')->with(['category' => $category, 'title' => 'Edit Supplier Category']);

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$category = Category::find($id);

		$data = request()->validate([

			'name' => 'required|string|min:3|max:30',

			'desc' => 'required|string|min:3|max:255',

			'parent_id' => 'sometimes|nullable|numeric',

			'photo' => 'sometimes|nullable|' . validate_image(),

		]);

		if (request()->hasFile('photo')) {

			$data['photo'] = upload([

				'file' => 'photo',
				'folder' => 'categories',
				'type' => 'single',
				'delete_file' => $category->photo,

			]);

		} else {
			unset($data['photo']);
		}

		$category->update($data);

		session()->flash('success', 'Supplier Category Updated Successfully');

		return redirect()->route('supplier-categories.index');

	}

	public function destroyAll() {
		if (request('items')) {

			foreach (request('items') as $id) {

				$category = Category::find($id);

				$category->delete();
			}

			session()->flash('success', 'Supplier Categories Deleted Successfully');

		} else {
			session()->flash('error', 'Supplier Categories Can\'t Deleted Successfully');
		}

		return redirect()->route('supplier-categories.index');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$category = Category::find($id);

		$childrens = $category->childrens($id);

		foreach ($childrens as $children) {

			if ($children->photo) {
				delete_file($children->photo);
			}

			$children->delete();
		}

		if ($category->photo) {
			delete_file($category->photo);
		}

		$category->delete();

		session()->flash('success', 'Supplier Category Deleted Successfully');

		return redirect()->route('supplier-categories.index');

	}
}
