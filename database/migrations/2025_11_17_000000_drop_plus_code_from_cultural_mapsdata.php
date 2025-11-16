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
        if (Schema::hasTable('cultural_mapsdata') && Schema::hasColumn('cultural_mapsdata', 'plus_code')) {
            Schema::table('cultural_mapsdata', function (Blueprint $table) {
                $table->dropColumn('plus_code');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('cultural_mapsdata') && !Schema::hasColumn('cultural_mapsdata', 'plus_code')) {
            Schema::table('cultural_mapsdata', function (Blueprint $table) {
                $table->string('plus_code', 32)->nullable()->after('longitude');
            });
        }
    }
};
