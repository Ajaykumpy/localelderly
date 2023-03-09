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
        Schema::table('promocode_user', function (Blueprint $table) {
            $table->foreign(['user_id'], 'promocode_user_package_id_foreign')->references(['id'])->on('packages')->onDelete('SET NULL');
            $table->foreign(['promocode_id'])->references(['id'])->on('promocodes')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promocode_user', function (Blueprint $table) {
            $table->dropForeign('promocode_user_package_id_foreign');
            $table->dropForeign('promocode_user_promocode_id_foreign');
        });
    }
};
