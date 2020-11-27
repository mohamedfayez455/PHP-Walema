<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnquiryFormBuilderInputsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('enquiry_form_builder_inputs', function (Blueprint $table) {
			$table->increments('id');

			$table->unsignedInteger('input_id');
			$table->foreign('input_id')->references('id')
				->on('create_input_fields')->onDelete('cascade');

			$table->boolean('publish');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('enquiry_form_builder_inputs');
	}
}
