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
        Schema::create('option_description', function (Blueprint $table) {
            $table->comment('');
            $table->integer('option_id');
            $table->integer('language_id');
            $table->string('name', 128);
            $table->string('uuid');

            $table->primary(['option_id', 'language_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('option_description');
    }
};
