<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('koleksi_bacaan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->foreign('siswa_id')->references('id')->on('siswa')->onDelete('cascade');

            // Data buku dari Google Books
            $table->string('volume_id', 100);
            $table->string('judul_buku', 300);
            $table->string('penulis', 255)->nullable();
            $table->string('cover_url', 500)->nullable();
            $table->string('reader_link', 500)->nullable();
            $table->string('kategori', 100)->default('Umum');

            // Progres membaca
            $table->enum('status', ['belum_dibaca', 'sedang_dibaca', 'selesai'])->default('belum_dibaca');
            $table->unsignedInteger('halaman_terakhir')->default(0);
            $table->unsignedInteger('total_halaman')->default(0);
            $table->text('catatan')->nullable();

            $table->timestamps();

            // Satu siswa hanya bisa menambahkan buku yang sama sekali saja
            $table->unique(['siswa_id', 'volume_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('koleksi_bacaan');
    }
};
