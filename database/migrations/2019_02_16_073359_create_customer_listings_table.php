<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerListingsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		Schema::create('customer_listings', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('customer_id')->unsigned();
			$table->integer('listing_id')->unsigned();
			$table->timestamps();

		});

		Schema::table('customer_listings', function (Blueprint $table) {
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
		Schema::dropIfExists('customer_listings');
	}
}
