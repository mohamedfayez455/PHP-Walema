<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersProfileFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers_profile_forms', function (Blueprint $table) {
            $table->increments('id');
            
            $table->unsignedInteger('input_id');
            $table->foreign('input_id')->references('id')
                  ->on('create_input_fields')->onDelete('cascade');

            $table->boolean('published_on_profile');
            $table->boolean('published_on_signup');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suppliers_profile_forms');
    }
}
