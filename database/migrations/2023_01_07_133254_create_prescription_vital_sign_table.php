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
        Schema::create('prescription_vital_sign', function (Blueprint $table) {
            $table->comment('');
            $table->integer('prescription_vital_sign_id', true);
            $table->string('uuid');
            $table->integer('prescription_id')->default(0);
            $table->string('name', 191);
            $table->string('key', 191);
            $table->string('value', 191);
            $table->string('value_class', 191);
            $table->integer('value_class_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescription_vital_sign');
    }
};
