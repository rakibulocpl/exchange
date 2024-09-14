<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->enum('gender',['male','female'])->default('male');
            $table->date('dob')->nullable();
            $table->string('phone')->unique();
            $table->string('email')->unique()->nullable();
            $table->tinyInteger('city')->default(0);
            $table->tinyInteger('thana')->default(0);
            $table->text('details_address')->nullable();
            $table->enum('user_type',['customer','admin','superman','vendor'])->default('customer');
            $table->enum('user_status',['active','inactive'])->default('active');
            $table->timestamp('last_login')->nullable();
            $table->string('password')->nullable();
            $table->integer('otp')->nullable();
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
        Schema::dropIfExists('users');
    }
}
