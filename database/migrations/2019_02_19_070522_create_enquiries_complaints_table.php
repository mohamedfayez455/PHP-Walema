<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnquiriesComplaintsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('enquiries_complaints', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('email');
			$table->string('message');
			$table->longtext('additional_data')->nullable();
			$table->enum('type', ['complaint', 'enquiry']);
			$table->integer('sender_id')->unsigned();
			$table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('reciever_id')->unsigned();
			$table->foreign('reciever_id')->references('id')->on('users')->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('enquiries_complaints');
	}
}
