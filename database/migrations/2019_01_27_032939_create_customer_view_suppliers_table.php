<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerViewSuppliersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('customer_view_suppliers', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('customer_id')->unsigned();
			$table->integer('supplier_id')->unsigned();
			$table->timestamps();

		});

		Schema::table('customer_view_suppliers', function (Blueprint $table) {
			$table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
			$table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {

		Schema::table('customer_view_suppliers', function (Blueprint $table) {

			$table->dropForeign(['customer_id', 'supplier_id']);

		});

		Schema::dropIfExists('customer_view_suppliers');
	}
}
