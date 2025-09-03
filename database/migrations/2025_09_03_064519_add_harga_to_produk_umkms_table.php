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
        Schema::table('produk_umkms', function (Blueprint $table) {
            $table->decimal('harga', 12, 2)->nullable()->after('deskripsi');
            $table->string('satuan')->default('pcs')->after('harga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk_umkms', function (Blueprint $table) {
            $table->dropColumn(['harga', 'satuan']);
        });
    }
};
