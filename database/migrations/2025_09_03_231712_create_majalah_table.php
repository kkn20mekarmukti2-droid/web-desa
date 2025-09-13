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
        Schema::create('majalah', function (Blueprint $table) {
            $table->id();
            $table->string('judul'); // Nama edisi/bulan majalah
            $table->text('deskripsi')->nullable(); // Deskripsi edisi
            $table->string('cover_image'); // Cover majalah  
            $table->boolean('is_active')->default(true); // Status aktif
            $table->date('tanggal_terbit'); // Tanggal terbit
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('majalah');
    }
};
