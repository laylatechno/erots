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
        Schema::create('iklan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_iklan');
            $table->string('pemilik');
            $table->string('no_wa');
            $table->string('link');
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
        Schema::dropIfExists('iklan');
    }
};
