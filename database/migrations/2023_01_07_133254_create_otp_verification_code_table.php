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
        Schema::create('otp_verification_code', function (Blueprint $table) {
            $table->comment('');
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->string('mobile', 50)->default('');
            $table->integer('otp');
            $table->string('status')->default('Pending');
            $table->string('expired_at')->nullable();
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
        Schema::dropIfExists('otp_verification_code');
    }
};
