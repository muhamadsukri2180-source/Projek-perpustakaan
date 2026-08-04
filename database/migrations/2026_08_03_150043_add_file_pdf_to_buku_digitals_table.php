<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buku_digitals', function (Blueprint $table) {
            // Hanya tambahkan file_pdf
            $table->string('file_pdf')->after('kategori');
        });
    }

    public function down(): void
    {
        Schema::table('buku_digitals', function (Blueprint $table) {
            $table->dropColumn('file_pdf');
        });
    }
};