<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersProfileFormsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('customers_profile_forms', function (Blueprint $table) {
			$table->increments('id');

			$table->unsignedInteger('input_id');
			$table->foreign('input_id')->references('id')
				->on('create_input_fields')->onDelete('cascade');

			$table->boolean('published_on_profile');
			$table->boolean('published_on_signup');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('customers_profile_forms');
	}
}
