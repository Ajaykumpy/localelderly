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
        Schema::create('doctor_devices', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->string('uuid');
            $table->integer('doctor_id');
            $table->string('device_id');
            $table->string('version_code')->nullable();
            $table->string('version_name')->nullable();
            $table->string('released')->nullable();
            $table->string('device_name')->nullable();
            $table->string('device_manufacturer')->nullable();
            $table->softDeletes()->useCurrentOnUpdate();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor_devices');
    }
};
