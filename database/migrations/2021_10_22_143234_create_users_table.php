<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_name');
            $table->string('user_email')->unique();
            $table->string('user_phone')->unique();
            $table->string('password');
            $table->string('user_image')->nullable();
            $table->string('lang_key');
            $table->decimal('user_balance',12,2)->default(0)->nullable();
            $table->string('user_otp');
            $table->string('user_google_key');
            $table->string('user_facebook_key');
            $table->string('user_apple_key');
            $table->enum('status', ['active', 'in_active', 'block'])->default('in_active');
            $table->enum('is_verified', [0, 1])->default(0)->comment('0 for not_verified 1 for verified');
            $table->enum('is_online', [0, 1])->default(0)->comment('0 for not_online 1 for online');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('last_login_ip');
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
