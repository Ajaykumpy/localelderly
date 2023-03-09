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
        Schema::create('doctor_profiles', function (Blueprint $table) {
            $table->comment('');
            $table->bigIncrements('doctor_profile_id');
            $table->integer('doctor_id');
            $table->string('address');
            $table->string('address_2');
            $table->string('age');
            $table->string('gender', 100);
            $table->string('state');
            $table->string('image');
            $table->string('tenth_std', 225);
            $table->string('twelfth_std');
            $table->string('graduation');
            $table->string('degree', 100);
            $table->string('yrs_of_exp', 110);
            $table->string('yrs_of_completion', 200);
            $table->string('registration_number', 200);
            $table->string('registration_council', 200);
            $table->string('registration_year', 110);
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('doctor_profiles');
    }
};
