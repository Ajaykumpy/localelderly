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
        Schema::create('patient_feedback', function (Blueprint $table) {
            $table->comment('');
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->string('doctor_id')->comment('feedback given by');
            $table->integer('user_id')->nullable()->comment('feedback given to');
            $table->integer('ratings')->nullable();
            $table->integer('max_rating')->default(5);
            $table->string('comment');
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
        Schema::dropIfExists('patient_feedback');
    }
};
