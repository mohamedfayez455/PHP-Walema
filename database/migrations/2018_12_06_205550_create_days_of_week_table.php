<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaysOfWeekTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('days_of_week', function (Blueprint $table) {
			$table->increments('id');
			$table->string('mondayTime')->default('Closed');
			$table->string('tuesdayTime')->default('Closed');
			$table->string('wednesdayTime')->default('Closed');
			$table->string('thrusdayTime')->default('Closed');
			$table->string('fridayTime')->default('Closed');
			$table->string('saturdayTime')->default('Closed');
			$table->string('sundayTime')->default('Closed');
			$table->integer('listing_id')->unsigned();
			$table->foreign('listing_id')->references('id')->on('listings')->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {

		Schema::table('days_of_week', function (Blueprint $table) {
			$tabele->dropForeign('listing_id');
		});

		Schema::dropIfExists('days_of_week');

	}
}
