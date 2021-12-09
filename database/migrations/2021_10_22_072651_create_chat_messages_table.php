<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('thread_id')->default(0);
            $table->bigInteger('item_id')->default(0);
            $table->bigInteger('from_id')->default(0);
            $table->bigInteger('to_id')->default(0);
            $table->text('message')->nullable();
            $table->enum('is_read', [0, 1])->default(0)->comment('0 for not_read 1 for read');
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
        Schema::dropIfExists('chat_messages');
    }
}
