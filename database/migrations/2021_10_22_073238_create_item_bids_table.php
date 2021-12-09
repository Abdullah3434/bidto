<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_bids', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->default(0);
            $table->bigInteger('item_id')->default(0);
            $table->decimal('bid_amount',10,2)->default(0);
            $table->enum('status', ['pending', 'approved', 'not_approved'])->default('pending');
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
        Schema::dropIfExists('item_bids');
    }
}
