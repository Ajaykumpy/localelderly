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
        Schema::create('packages', function (Blueprint $table) {
            $table->comment('');
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('description', 225);
            $table->string('image');
            $table->decimal('price', 20, 6)->default(0);
            $table->decimal('signup_fee', 20, 6)->default(0);
            $table->string('currency', 50);
            $table->tinyInteger('trial_period')->default(0);
            $table->string('trial_interval', 50)->default('day');
            $table->tinyInteger('invoice_period')->default(0);
            $table->string('invoice_interval', 50)->default('month');
            $table->tinyInteger('grace_period')->default(0);
            $table->string('grace_interval', 50)->default('day');
            $table->unsignedTinyInteger('prorate_day')->default(0);
            $table->unsignedTinyInteger('prorate_period')->default(0);
            $table->unsignedTinyInteger('prorate_extend_due')->default(0);
            $table->unsignedTinyInteger('active_subscribers_limit');
            $table->tinyInteger('status')->default(0);
            $table->string('deleted_at', 50)->nullable();
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
        Schema::dropIfExists('packages');
    }
};
