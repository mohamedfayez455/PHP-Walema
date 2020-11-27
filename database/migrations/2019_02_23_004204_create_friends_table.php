<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('friends', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('customer_id')->unsigned();
			$table->integer('supplier_id')->unsigned();
			$table->timestamps();
		});

		Schema::table('friends', function (Blueprint $table) {
			$table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('supplier_id')->references('id')->on('users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('friends');
	}
}
