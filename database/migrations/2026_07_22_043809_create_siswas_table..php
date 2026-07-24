<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nisn')->unique();
            $table->string('nama');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('jurusan_id')->constrained('jurusan')->onDelete('cascade');
            $table->enum('jenis_kelamin', ['L', 'P'])->default('L');
            $table->string('barcode_code')->unique()->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('siswa'); }
};