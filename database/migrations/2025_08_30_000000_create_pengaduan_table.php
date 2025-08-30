<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('no_hp');
            $table->string('alamat_lengkap');
            $table->text('isi');
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('pengaduan');
    }
};
