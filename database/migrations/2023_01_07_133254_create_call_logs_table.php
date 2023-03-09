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
        Schema::create('call_logs', function (Blueprint $table) {
            $table->comment('');
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->integer('user_id')->nullable()->comment('id of patient');
            $table->integer('doctor_id')->nullable()->comment('id of doctor');
            $table->string('meeting_id', 30)->nullable();
            $table->integer('call_request_id')->nullable();
            $table->string('status', 30)->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->bigInteger('duration')->nullable();
            $table->string('type', 20)->nullable()->comment('call request from which app');
            $table->string('latitude', 20)->nullable();
            $table->string('longitude', 20)->nullable();
            $table->softDeletes();
            $table->timestamp('created_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('call_logs');
    }
};
