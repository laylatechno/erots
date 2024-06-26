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
        Schema::create('imt', function (Blueprint $table) {
            $table->id();
            $table->string('umur');
            $table->string('jenis_kelamin');
            $table->string('min_3_sd');
            $table->string('min_2_sd');
            $table->string('min_1_sd');
            $table->string('median');
            $table->string('max_1_sd');
            $table->string('max_2_sd');
            $table->string('max_3_sd');
            $table->string('urutan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imt');
    }
};
