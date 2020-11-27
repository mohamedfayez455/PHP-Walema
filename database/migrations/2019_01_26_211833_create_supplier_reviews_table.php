<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierReviewsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('supplier_reviews', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('supplier_id');
			$table->unsignedInteger('listing_id');
			$table->text('body');
			$table->tinyInteger('rating')->unsigned()->default(0);
			$table->timestamps();
		});

		Schema::table('supplier_reviews', function (Blueprint $table) {

			$table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
			$table->foreign('listing_id')->references('id')->on('listings')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {

		Schema::table('supplier_reviews', function (Blueprint $table) {

			$table->dropForeign(['supplier_id', 'listing_id']);

		});

		Schema::dropIfExists('supplier_reviews');

	}
}
