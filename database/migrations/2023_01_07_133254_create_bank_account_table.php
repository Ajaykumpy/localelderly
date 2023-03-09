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
        Schema::create('bank_account', function (Blueprint $table) {
            $table->comment('');
            $table->integer('bank_account_id', true);
            $table->integer('doctor_id');
            $table->string('bank_account_number');
            $table->string('confirmed_account_number');
            $table->string('bank_ifsc_code', 64);
            $table->string('account_holder_name');
            $table->boolean('status');
            $table->dateTime('date_added');
            $table->integer('created_by');
            $table->timestamps();
            $table->integer('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_account');
    }
};
