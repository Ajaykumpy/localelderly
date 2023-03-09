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
        Schema::create('call_request_filters', function (Blueprint $table) {
            $table->comment('');
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->unsignedBigInteger('call_request_id')->index('request_filters_request_id_foreign');
            $table->unsignedBigInteger('doctor_id')->index('request_filters_provider_id_foreign');
            $table->integer('status')->default(0);
            $table->integer('notification')->nullable()->default(0);
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
        Schema::dropIfExists('call_request_filters');
    }
};
