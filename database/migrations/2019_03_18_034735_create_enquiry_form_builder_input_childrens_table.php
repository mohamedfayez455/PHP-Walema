<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnquiryFormBuilderInputChildrensTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('enquiry_form_builder_input_childrens', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('enquiry_input_id');
			$table->foreign('enquiry_input_id')->references('id')
				->on('enquiry_form_builder_inputs')->onDelete('cascade');

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
		Schema::dropIfExists('enquiry_form_builder_input_childrens');
	}
}
