<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cultural_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cultural_id')->constrained('culturals')->onDelete('cascade');
            $table->string('image_path'); // simpan path gambar
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cultural_galleries');
    }
};
