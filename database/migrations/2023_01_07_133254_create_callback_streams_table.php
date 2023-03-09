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
        Schema::create('callback_streams', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->string('uuid');
            $table->integer('call_log_id')->nullable();
            $table->integer('call_request_id')->nullable();
            $table->string('meeting_id')->nullable();
            $table->bigInteger('appid')->nullable();
            $table->bigInteger('begin_time')->nullable();
            $table->bigInteger('end_time')->nullable();
            $table->string('event')->nullable();
            $table->longText('extra_params')->nullable();
            $table->bigInteger('nonce')->nullable();
            $table->string('replay_url')->nullable();
            $table->string('signature')->nullable();
            $table->string('stream_alias')->nullable();
            $table->string('stream_id')->nullable();
            $table->string('type', 20)->nullable();
            $table->bigInteger('timestamp')->nullable();
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
        Schema::dropIfExists('callback_streams');
    }
};
