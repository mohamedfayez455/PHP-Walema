<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('favorites', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('customer_id')->unsigned();
			$table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
			$table->integer('supplier_id')->unsigned();
			$table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {

		Schema::table('favorites', function (Blueprint $table) {

			$table->dropForeign(['supplier_id', 'customer_id']);

		});

		Schema::dropIfExists('favorites');
	}
}
