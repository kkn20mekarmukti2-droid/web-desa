<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('struktur_pemerintahans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan');
            $table->string('foto')->nullable();
            $table->integer('urutan')->default(1); // Untuk mengurutkan hierarki
            $table->enum('kategori', ['kepala_desa', 'sekretaris', 'kepala_urusan', 'kepala_seksi', 'kepala_dusun'])->default('kepala_seksi');
            $table->string('pendidikan')->nullable();
            $table->text('tugas_pokok')->nullable();
            $table->string('no_sk')->nullable(); // Nomor SK pengangkatan
            $table->date('tgl_sk')->nullable(); // Tanggal SK
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('struktur_pemerintahans');
    }
};
