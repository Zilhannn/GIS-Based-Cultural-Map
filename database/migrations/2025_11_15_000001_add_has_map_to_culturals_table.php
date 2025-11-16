<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('culturals', function (Blueprint $table) {
            if (!Schema::hasColumn('culturals', 'has_map')) {
                $table->boolean('has_map')->default(0)->after('image');
            }
        });
    }

    public function down()
    {
        Schema::table('culturals', function (Blueprint $table) {
            if (Schema::hasColumn('culturals', 'has_map')) {
                $table->dropColumn('has_map');
            }
        });
    }
};
