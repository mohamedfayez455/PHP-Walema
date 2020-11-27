<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerReviewsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('customer_reviews', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('customer_id');
			$table->unsignedInteger('listing_id');
			$table->text('body');
			$table->tinyInteger('rating')->unsigned()->default(0);
			$table->timestamps();
		});

		Schema::table('customer_reviews', function (Blueprint $table) {

			$table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
			$table->foreign('listing_id')->references('id')->on('listings')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {

		Schema::table('customer_reviews', function (Blueprint $table) {

			$table->dropForeign(['customer_id', 'listing_id']);

		});

		Schema::dropIfExists('customer_reviews');

	}
}
