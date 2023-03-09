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
        Schema::create('company_employee_packages', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->string('uuid');
            $table->mediumInteger('package_id');
            $table->string('company_name', 100);
            $table->string('user_name', 100);
            $table->bigInteger('user_mobile');
            $table->string('user_email', 100);
            $table->string('activation_code', 20);
            $table->string('status', 50)->default('Pending');
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
        Schema::dropIfExists('company_employee_packages');
    }
};
