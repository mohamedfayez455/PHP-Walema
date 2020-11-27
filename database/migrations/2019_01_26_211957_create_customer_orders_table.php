<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerOrdersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('customer_orders', function (Blueprint $table) {
			$table->increments('id');
			$table->float('amount');
			$table->enum('status', ['pending', 'active', 'canceled']);
			$table->integer('customer')->unsigned();
			$table->timestamps();
		});

		Schema::table('customer_orders', function (Blueprint $table) {
			$table->foreign('customer')->references('id')->on('customers')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {

		Schema::table('customer_orders', function (Blueprint $table) {

			$table->dropForeign(['customer']);

		});

		Schema::dropIfExists('customer_orders');

	}
}
