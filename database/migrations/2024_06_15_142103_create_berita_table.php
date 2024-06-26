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
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kategori_berita_id');
            $table->string('judul_berita');
            $table->string('slug');
            $table->date('tanggal_posting')->nullable();
            $table->string('penulis')->nullable();
            $table->string('ringkasan')->nullable();
            $table->text('isi')->nullable();
            $table->string('sumber')->nullable();
            $table->string('gambar')->nullable();
            $table->string('status')->nullable();
            $table->string('urutan')->nullable();
            $table->integer('views')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
