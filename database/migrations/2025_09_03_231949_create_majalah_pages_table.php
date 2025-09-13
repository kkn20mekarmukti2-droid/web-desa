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
        Schema::create('majalah_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('majalah_id')->constrained('majalah')->onDelete('cascade');
            $table->integer('page_number'); // Nomor halaman (1, 2, 3, dst)
            $table->string('image_path'); // Path gambar halaman
            $table->string('title')->nullable(); // Judul halaman (opsional)
            $table->text('description')->nullable(); // Deskripsi halaman (opsional)
            $table->timestamps();
            
            // Index untuk performa
            $table->index(['majalah_id', 'page_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('majalah_pages');
    }
};
