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
        Schema::create('visitor_toko', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->unsignedBigInteger('user_id'); // Foreign key for user
            $table->timestamp('visit_time');
            $table->string('ip_address');
            $table->string('session_id');
            $table->string('user_agent');
            $table->string('device');
            $table->string('platform');
            $table->string('browser');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Ensure referential integrity

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_toko');
    }
};
