<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->string('email')->unique();
			$table->string('firstname');
			$table->string('lastname');
			$table->string('password');
			$table->string('avatar')->nullable();
			$table->integer('country_id')->unsigned();
			$table->foreign('country_id')->references('id')
				->on('countries')->onDelete('cascade');
			$table->string('role')->default('supplier');
			$table->boolean('verified')->default(0);
			$table->boolean('approved')->default(0);
			$table->string('token')->nullable();
			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('users');
	}
}
