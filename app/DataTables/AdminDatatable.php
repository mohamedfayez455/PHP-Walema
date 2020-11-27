<?php

namespace App\DataTables;

use App\Admin;
use URL;
use Yajra\DataTables\Services\DataTable;

class AdminDatatable extends DataTable {
	/**
	 * Build DataTable class.
	 *
	 * @param mixed $query Results from query() method.
	 * @return \Yajra\DataTables\DataTableAbstract
	 */
	public function dataTable($query) {
		return datatables($query)
			->addColumn('checkbox', 'admin.admins.buttons.checkbox')
			->addColumn('edit', 'admin.admins.buttons.edit')
			->addColumn('delete', 'admin.admins.buttons.delete')
			->rawColumns([
				'edit',
				'delete',
				'checkbox',
			]);
	}

	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\User $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query() {
		return Admin::query();
	}

	/**
	 * Optional method if you want to use html builder.
	 *
	 * @return \Yajra\DataTables\Html\Builder
	 */
	public function html() {
		return $this->builder()
			->columns($this->getColumns())
			->minifiedAjax()
			->parameters([
				'dom' => 'Blfrtip',
				'lengthMenu' => [[10, 25, 50, 100], [10, 25, 50, 'All']],
				'buttons' => [

					[
						'className' => 'btn btn-info',
						'text' => '<i class="fa fa-plus"> Create Admin</i>',
						'action' => "function(){
                                    window.location.href = '" . URL::Current() . "/create';
                                }",
					],
					[
						'className' => 'btn btn-danger deleteBtn',
						'text' => '<i class="fa fa-trash"> Delete </i>',
					],
					[
						'className' => 'btn btn-default',
						'text' => '<i class="fa fa-refresh"> Reload</i>',
						'extend' => "reload",
					],

				],
				'initComplete' => ' function () {
                            this.api().columns([2,3,4]).every(function () {
                                var column = this;
                                var input = document.createElement("input");
                                $(input).appendTo($(column.footer()).empty())
                                .on(\'keyup\', function () {
                                    column.search($(this).val(), false, false, true).draw();
                                });
                            });
                        }',

			]);
	}

	/**
	 * Get columns.
	 *
	 * @return array
	 */
	protected function getColumns() {
		return [

			[
				'name' => 'checkbox',
				'data' => 'checkbox',
				'title' => '<input type="checkbox" class="check_all_items" onclick="checkAllItem()">',
				'exportable' => false,
				'printable' => false,
				'orderable' => false,
				'searchable' => false,
			],
			[
				'name' => 'id',
				'data' => 'id',
				'title' => 'id',
			],
			[
				'name' => 'firstname',
				'data' => 'firstname',
				'title' => 'First Name',
			],
			[
				'name' => 'lastname',
				'data' => 'lastname',
				'title' => 'Last Name',
			],
			[
				'name' => 'email',
				'data' => 'email',
				'title' => 'Email',
			],
			[
				'name' => 'edit',
				'data' => 'edit',
				'title' => 'edit',
				'exportable' => false,
				'printable' => false,
				'orderable' => false,
				'searchable' => false,
			],
			[
				'name' => 'delete',
				'data' => 'delete',
				'title' => 'delete',
				'exportable' => false,
				'printable' => false,
				'orderable' => false,
				'searchable' => false,
			],
		];
	}

	/**
	 * Get filename for export.
	 *
	 * @return string
	 */
	protected function filename() {
		return 'Admin_' . date('YmdHis');
	}
}
