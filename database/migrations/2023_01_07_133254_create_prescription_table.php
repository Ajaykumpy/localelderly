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
        Schema::create('prescription', function (Blueprint $table) {
            $table->comment('');
            $table->integer('prescription_id', true);
            $table->string('uuid');
            $table->text('diagnosis');
            $table->string('weight', 50)->default('0');
            $table->string('weight_class', 50)->default('');
            $table->integer('weight_class_id')->default(0);
            $table->text('description');
            $table->date('date');
            $table->integer('patient_id');
            $table->integer('doctor_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescription');
    }
};
