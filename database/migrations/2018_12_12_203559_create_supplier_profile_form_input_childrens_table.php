<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierProfileFormInputChildrensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_profile_input_childrens', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('supplier_input_id');
            $table->foreign('supplier_input_id')->references('id')
                  ->on('suppliers_profile_forms')->onDelete('cascade');

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
    public function down()
    {
        Schema::dropIfExists('supplier_profile_input_childrens');
    }
}
