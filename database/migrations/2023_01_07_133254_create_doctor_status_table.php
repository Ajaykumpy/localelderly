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
        Schema::create('doctor_status', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->string('uuid');
            $table->integer('user_id');
            $table->date('date')->nullable();
            $table->time('from_time')->nullable();
            $table->time('to_time')->nullable();
            $table->integer('total_min')->nullable();
            $table->integer('total_hrs')->nullable();
            $table->decimal('latitude', 20, 6)->nullable();
            $table->decimal('longitude', 20, 6)->nullable();
            $table->point('position')->nullable();
            $table->string('status', 11)->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('doctor_status');
    }
};
