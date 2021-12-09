<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('admin_name')->nullable();
            $table->string('admin_email')->unique();
            $table->string('password');
            $table->string('admin_image')->nullable();
            $table->enum('status', ['active', 'in_active'])->default('active');
            $table->enum('admin_type', ['admin', 'sub_admin'])->default('admin');
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
        Schema::drop('admins');
    }
}
