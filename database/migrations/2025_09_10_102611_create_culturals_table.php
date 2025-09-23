<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('culturals', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // nama kebudayaan
            $table->string('category')->nullable(); // kategori (bangunan, makanan, tarian)
            $table->string('location')->nullable(); // lokasi kebudayaan
            $table->text('description')->nullable(); // deskripsi panjang
            $table->text('history')->nullable(); // sejarah singkat
            $table->text('nowaday')->nullable(); // keadaan sekarang
            $table->text('cult_now')->nullable(); // deskripsi panjang
            $table->string('image')->nullable(); // path gambar
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('culturals');
    }
};
