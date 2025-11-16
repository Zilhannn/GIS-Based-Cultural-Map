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
        Schema::table('cultural_mapsdata', function (Blueprint $table) {
            if (!Schema::hasColumn('cultural_mapsdata', 'plus_code')) {
                $table->string('plus_code', 32)->nullable()->after('longitude');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cultural_mapsdata', function (Blueprint $table) {
            if (Schema::hasColumn('cultural_mapsdata', 'plus_code')) {
                $table->dropColumn('plus_code');
            }
        });
    }
};
