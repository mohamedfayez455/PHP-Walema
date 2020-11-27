<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierOrdersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('supplier_orders', function (Blueprint $table) {
			$table->increments('id');
			$table->float('amount');
			$table->enum('status', ['pending', 'active', 'canceled']);
			$table->integer('customer')->unsigned();

			$table->timestamps();
		});

		Schema::table('supplier_orders', function (Blueprint $table) {
			$table->foreign('customer')->references('id')->on('suppliers')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {

		Schema::table('supplier_orders', function (Blueprint $table) {

			$table->dropForeign(['customer']);

		});

		Schema::dropIfExists('supplier_orders');

	}
}
