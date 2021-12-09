<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->default(0);
            $table->integer('category_id')->default(0);
            $table->string('item_name');
            $table->longtext('item_description');
            $table->enum('item_type', ['item', 'service', 'request'])->default('item');
            $table->enum('is_promotion', [0, 1])->default(0)->comment('0 for not_read 1 for read');
            $table->integer('item_promotion_days')->default(0);
            $table->decimal('item_from_price',10,2)->default(0);
            $table->decimal('item_to_price',10,2)->default(0);
            $table->string('item_location')->nullable();
            $table->string('item_latitude')->nullable();
            $table->string('item_longitude')->nullable();
            $table->bigInteger('item_total_views')->default(0);
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
        Schema::dropIfExists('items');
    }
}
