<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            // Foreign key mengarah ke tabel siswas
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('waktu_masuk');
            $table->time('waktu_keluar')->nullable();
            $table->enum('status', ['di_perpus', 'selesai'])->default('di_perpus');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};