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
        Schema::create('kurir', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kurir');
            $table->string('no_wa');
            $table->string('alamat');
            $table->string('afiliasi');
            $table->string('tempat_lahir'); // Tambahkan kolom tempat lahir
            $table->date('tanggal_lahir'); // Tambahkan kolom tanggal lahir
            $table->text('deskripsi')->nullable();
            $table->string('urutan');
            $table->string('gambar');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurir');
    }
};
