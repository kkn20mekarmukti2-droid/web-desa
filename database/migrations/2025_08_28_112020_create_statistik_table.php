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
        Schema::create('statistik', function (Blueprint $table) {
            $table->id();
            $table->string('kategori'); // 'jenis_kelamin', 'agama', 'pekerjaan'
            $table->string('label'); // 'Laki-laki', 'Perempuan', 'Islam', 'Kristen', etc.
            $table->integer('jumlah')->default(0); // jumlah data
            $table->text('deskripsi')->nullable(); // deskripsi tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistik');
    }
};
