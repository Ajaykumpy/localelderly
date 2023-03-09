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
        Schema::create('question_option', function (Blueprint $table) {
            $table->comment('');
            $table->integer('question_option_id', true);
            $table->string('uuid');
            $table->integer('question_id')->nullable();
            $table->string('type', 50)->nullable();
            $table->string('name', 50)->nullable();
            $table->string('image', 50)->nullable();
            $table->decimal('score', 15, 4)->nullable();
            $table->text('comment')->nullable();
            $table->integer('sort_order')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_option');
    }
};
