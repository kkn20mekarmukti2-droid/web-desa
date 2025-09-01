<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produk_umkms', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->text('deskripsi');
            $table->string('gambar')->nullable();
            $table->string('nomor_telepon');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk_umkms');
    }
};
