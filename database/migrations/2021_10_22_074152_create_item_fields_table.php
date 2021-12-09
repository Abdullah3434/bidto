<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('item_id')->default(0);
            $table->integer('item_type_id')->default(0);
            $table->integer('item_make_id')->default(0);
            $table->integer('item_model_id')->default(0);
            $table->integer('item_year_old')->default(0);
            $table->integer('item_year_new')->default(0);
            $table->integer('item_condition_id')->default(0);
            $table->integer('item_exterior_color_id')->default(0);
            $table->integer('item_interior_color_id')->default(0);
            $table->integer('item_transmission_id')->default(0);
            $table->integer('item_cylinder_id')->default(0);
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
        Schema::dropIfExists('item_fields');
    }
}
