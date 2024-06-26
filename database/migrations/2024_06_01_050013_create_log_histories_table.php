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
        Schema::create('log_histories', function (Blueprint $table) {
            $table->id();
            $table->string('Tabel_Asal', 50)->nullable();
            $table->unsignedBigInteger('ID_Entitas')->nullable();
            $table->enum('Aksi', ['Create', 'Read', 'Update', 'Delete'])->nullable();
            $table->timestamp('Waktu')->nullable();
            $table->string('Pengguna', 50)->nullable();
            $table->text('Data_Lama')->nullable();
            $table->text('Data_Baru')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_histories');
    }
};
