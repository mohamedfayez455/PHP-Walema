<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerProfileFormInputChildrensTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('customer_profile_input_childrens', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('customer_input_id');
			$table->foreign('customer_input_id')->references('id')
				->on('customers_profile_forms')->onDelete('cascade');

			$table->unsignedInteger('input_id');
			$table->foreign('input_id')->references('id')
				->on('create_input_fields')->onDelete('cascade');

			$table->string('name');

			$table->string('value');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('customer_profile_input_childrens');
	}
}
