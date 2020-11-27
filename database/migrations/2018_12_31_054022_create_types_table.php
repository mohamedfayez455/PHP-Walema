<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('types', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('slug');
			$table->text('desc')->nullable();
			$table->string('photo')->default('types/default.jpg');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('types');
	}
}
