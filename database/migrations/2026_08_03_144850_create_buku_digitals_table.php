<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku_digitals', function (Blueprint $table) {$table->id();
            $table->string('judul_buku');$table->string('penulis')->nullable();
            $table->string('kategori')->default('Umum');$table->integer('tahun_terbit')->nullable();
            $table->string('cover')->nullable(); // Path gambar cover$table->string('file_pdf');         // Path file PDF
            $table->unsignedBigInteger('jumlah_dibaca')->default(0);$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_digitals');
    }
};