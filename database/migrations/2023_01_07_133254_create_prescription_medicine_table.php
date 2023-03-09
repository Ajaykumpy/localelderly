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
        Schema::create('prescription_medicine', function (Blueprint $table) {
            $table->comment('');
            $table->integer('prescription_medicine_id', true);
            $table->string('uuid');
            $table->integer('prescription_category_id');
            $table->integer('medicine_id');
            $table->string('medicine_name', 50);
            $table->integer('quantity')->default(0);
            $table->string('strength', 50);
            $table->string('strength_unit', 50);
            $table->string('dosage', 50)->comment('no use');
            $table->string('dosage_unit', 50);
            $table->string('duration', 50)->comment('use as period');
            $table->string('duration_unit', 50);
            $table->string('preparation', 50);
            $table->text('direction');
            $table->text('note');
            $table->integer('prescription_id');
            $table->integer('patient_id');
            $table->integer('doctor_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescription_medicine');
    }
};
