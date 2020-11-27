<?php

namespace App\DataTables;

use App\Supplier;
use URL;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Services\DataTable;

class SupplierDatatable extends DataTable {
	/**
	 * Build DataTable class.
	 *
	 * @param mixed $query Results from query() method.
	 * @return \Yajra\DataTables\DataTableAbstract
	 */
	public function dataTable($query) {

		return datatables($query)
			->addColumn('checkbox', 'admin.suppliers.buttons.checkbox')
			->addColumn('edit', 'admin.suppliers.buttons.edit')
			->addColumn('avatar', 'admin.suppliers.buttons.photo')
			->addColumn('delete', 'admin.suppliers.buttons.delete')
			->addColumn('approval', 'admin.suppliers.buttons.approval')
			->addColumn('chat_history', 'admin.suppliers.buttons.chat_history')
			->rawColumns([
				'edit',
				'delete',
				'checkbox',
				'avatar',
				'approval',
				'chat_history',
			]);
	}

	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\User $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query(DataTables $dataTables) {

		return Supplier::query()->with('user');
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
				'dom' => 'Bfrtip',
				'lengthMenu' => [[10, 25, 50, 100], [10, 25, 50, 'All']],
				'buttons' => [

					[
						'className' => 'btn btn-info',
						'text' => '<i class="fa fa-plus"> Create Supplier</i>',
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
				'name' => 'name',
				'data' => 'name',
				'title' => 'Full Name',
			],
			[
				'name' => 'email',
				'data' => 'user.email',
				'title' => 'Email',
			],
			[
				'name' => 'categories',
				'data' => 'categories',
				'title' => 'Categories',
			],
			[
				'name' => 'avatar',
				'data' => 'avatar',
				'title' => 'Avatar',
				'exportable' => false,
				'printable' => false,
				'orderable' => false,
				'searchable' => false,
			],
			[
				'name' => 'approval',
				'data' => 'approval',
				'title' => 'Approval',
				'exportable' => false,
				'printable' => false,
				'orderable' => false,
				'searchable' => false,
			],
			[
				'name' => 'chat_history',
				'data' => 'chat_history',
				'title' => 'Chat History',
				'exportable' => false,
				'printable' => false,
				'orderable' => false,
				'searchable' => false,
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
		return 'supplierdatatable_' . time();
	}
}
