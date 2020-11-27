<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInputAttributesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('attributes_input_fields', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('input_fields_id');
			$table->foreign('input_fields_id')->references('id')->on('create_input_fields')
				->onDelete('cascade');

			$table->unsignedInteger('attributes_id');
			$table->foreign('attributes_id')->references('id')->on('attributes')
				->onDelete('cascade');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('input_attributes', function (Blueprint $table) {

			$table->dropForeign(['attributes_id', 'input_fields_id']);

		});

		Schema::dropIfExists('input_attributes');

	}
}
