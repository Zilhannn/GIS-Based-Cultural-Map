<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('cultural_mapsdata', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cultural_id'); // relasi ke tabel culturals
            $table->double('latitude');
            $table->double('longitude');
            $table->timestamps();

            // Foreign key ke tabel culturals
            $table->foreign('cultural_id')
                  ->references('id')
                  ->on('culturals')
                  ->onDelete('cascade');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('cultural_mapsdata');
    }
};
