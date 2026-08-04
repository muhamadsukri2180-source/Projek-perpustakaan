<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Menambahkan kolom-kolom Google Books ke tabel buku_digitals.
 * 
 * Kolom baru:
 * - google_volume_id : ID unik buku dari Google Books API
 * - cover_url        : URL gambar cover dari Google Books
 * - reader_url       : URL preview buku dari Google Books
 * - sumber           : Penanda sumber buku ('lokal' atau 'google_books')
 * 
 * Perubahan:
 * - file_pdf diubah menjadi nullable (buku Google Books tidak punya PDF lokal)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buku_digitals', function (Blueprint $table) {
            // ID Volume dari Google Books (contoh: "zyTCAlFPjgYC")
            $table->string('google_volume_id')->nullable()->after('id');
            
            // URL cover buku dari Google Books
            $table->string('cover_url')->nullable()->after('cover');
            
            // URL preview/reader buku dari Google Books
            $table->string('reader_url')->nullable()->after('cover_url');
            
            // Penanda sumber buku: 'lokal' (upload PDF) atau 'google_books'
            $table->string('sumber')->default('lokal')->after('jumlah_dibaca');
        });

        // Ubah file_pdf menjadi nullable agar buku Google Books bisa disimpan tanpa PDF
        Schema::table('buku_digitals', function (Blueprint $table) {
            $table->string('file_pdf')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('buku_digitals', function (Blueprint $table) {
            $table->dropColumn(['google_volume_id', 'cover_url', 'reader_url', 'sumber']);
        });

        Schema::table('buku_digitals', function (Blueprint $table) {
            $table->string('file_pdf')->nullable(false)->change();
        });
    }
};
