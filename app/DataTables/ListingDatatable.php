<?php

namespace App\DataTables;

use App\Listing;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Services\DataTable;

class ListingDatatable extends DataTable {
	/**
	 * Build DataTable class.
	 *
	 * @param mixed $query Results from query() method.
	 * @return \Yajra\DataTables\DataTableAbstract
	 */
	public function dataTable($query) {

		return datatables($query)
			->addColumn('checkbox', 'admin.listings.buttons.checkbox')
			->addColumn('status', 'admin.listings.buttons.status')
			->addColumn('control', 'admin.listings.buttons.approval')
			->addColumn('photo', 'admin.listings.buttons.photo')
			->rawColumns([
				'checkbox',
				'control',
				'status',
				'photo',
			]);
	}

	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\User $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query(DataTables $dataTables) {

		return Listing::query();
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
				'title' => 'Name',
			],
			[
				'name' => 'tags',
				'data' => 'tags',
				'title' => 'tags',
			],
			[
				'name' => 'price',
				'data' => 'price',
				'title' => 'Price',
			],
			[
				'name' => 'photo',
				'data' => 'photo',
				'title' => 'Main Photo',
				'exportable' => false,
				'printable' => false,
				'orderable' => false,
				'searchable' => false,
			],
			[
				'name' => 'status',
				'data' => 'status',
				'title' => 'Status',
				'exportable' => false,
				'printable' => false,
				'orderable' => false,
				'searchable' => false,
			],
			[
				'name' => 'control',
				'data' => 'control',
				'title' => 'Control',
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
