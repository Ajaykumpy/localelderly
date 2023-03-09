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
        Schema::create('prescription_symptom', function (Blueprint $table) {
            $table->comment('');
            $table->integer('prescription_symptom_id', true);
            $table->integer('prescription_id')->default(0);
            $table->string('uuid');
            $table->string('symptom', 191);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescription_symptom');
    }
};
