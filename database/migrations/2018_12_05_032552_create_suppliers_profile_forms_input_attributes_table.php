<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersProfileFormsInputAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers_profile_form_input_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('input_id');
            $table->foreign('input_id')->references('id')
                  ->on('suppliers_profile_forms')->onDelete('cascade');
            
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
    public function down()
    {
        Schema::dropIfExists('suppliers_profile_forms_input_attributes');
    }
}
