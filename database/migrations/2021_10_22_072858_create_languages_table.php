<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lang_name');
            $table->string('lang_flag');
            $table->string('lang_key');
            $table->string('currency_name');
            $table->string('currency_symbol');
            $table->string('currency_code');
            $table->decimal('currency_value',10,2)->default(0);
            $table->enum('is_default', ['0', '1'])->default('0');
            $table->enum('status', ['active', 'in_active'])->default('active');
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
        Schema::dropIfExists('languages');
    }
}
