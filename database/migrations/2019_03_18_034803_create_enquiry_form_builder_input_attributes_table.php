<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnquiryFormBuilderInputAttributesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('enquiry_form_builder_input_attributes', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('input_id');
			$table->foreign('input_id')->references('id')
				->on('enquiry_form_builder_inputs')->onDelete('cascade');

			$table->unsignedInteger('attr_id');
			$table->foreign('attr_id')->references('id')
				->on('attributes')->onDelete('cascade');

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
		Schema::dropIfExists('enquiry_form_builder_input_attributes');
	}
}
