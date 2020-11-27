<?php

namespace App\DataTables;

use App\Customer;
use URL;
use Yajra\DataTables\Services\DataTable;

class CustomerDatatable extends DataTable {
	/**
	 * Build DataTable class.
	 *
	 * @param mixed $query Results from query() method.
	 * @return \Yajra\DataTables\DataTableAbstract
	 */
	public function dataTable($query) {
		return datatables($query)
			->addColumn('checkbox', 'admin.customers.buttons.checkbox')
			->addColumn('edit', 'admin.customers.buttons.edit')
			->addColumn('avatar', 'admin.customers.buttons.photo')
			->addColumn('delete', 'admin.customers.buttons.delete')
			->addColumn('approval', 'admin.customers.buttons.approval')
			->addColumn('chat_history', 'admin.customers.buttons.chat_history')
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
	public function query() {
		return Customer::query()->with('user');
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
				'order' => [[0, 'desc']],
				'buttons' => [

					[
						'className' => 'btn btn-info',
						'text' => '<i class="fa fa-plus"> Create Customer</i>',
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
                            this.api().columns([2,3]).every(function () {
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
				'name' => 'avatar',
				'data' => 'avatar',
				'title' => 'avatar',
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
				'name' => 'approval',
				'data' => 'approval',
				'title' => 'approval',
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
		return 'customerdatatable_' . time();
	}
}
