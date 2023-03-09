<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->comment('');
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->bigInteger('mobile')->nullable();
            $table->string('gender');
            $table->string('pin')->nullable();
            $table->string('room_no');
            $table->string('street_name');
            $table->string('location');
            $table->string('blood_group');
            $table->string('image');
            $table->string('existing_disease');
            $table->string('age', 100);
            $table->string('height', 100);
            $table->string('weight');
            $table->tinyInteger('status')->default(0);
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
};
