<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('listings', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name')->nullable();
			$table->text('description')->nullable();
			$table->integer('category_id')->unsigned();
			$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
			$table->string('main_photo')->nullable();
			$table->float('price')->nullable();
			$table->string('tags', 255)->nullable();
			$table->integer('supplier_id')->unsigned();
			$table->enum('status', ['pending', 'active', 'canceled'])->default('pending');
			$table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {

		Schema::table('listings', function (Blueprint $table) {
			$table->dropForeign(['supplier_id', 'category_id']);
		});

		Schema::dropIfExists('supplier_listings');
	}
}
