<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewRepliesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('review_replies', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('review_id')->unsigned();
			$table->foreign('review_id')->references('id')->on('customer_reviews')->onDelete('cascade');
			$table->integer('supplier_id')->unsigned();
			$table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
			$table->text('body');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('review_replies');
	}
}
