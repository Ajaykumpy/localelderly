<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('postmeta', function (Blueprint $table) {
            $table->comment('');
            $table->bigIncrements('meta_id');
            $table->unsignedBigInteger('post_id')->default(0)->index('post_id');
            $table->string('meta_key')->nullable();
            $table->longText('meta_value')->nullable();

            $table->index([DB::raw("meta_key(250)")], 'meta_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('postmeta');
    }
};
