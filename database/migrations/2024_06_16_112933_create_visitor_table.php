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
        Schema::create('visitor', function (Blueprint $table) {
            // Mengubah id menjadi visitor_id, tipe integer dan primary key
            $table->integer('visitor_id')->default(10)->primary();

            // Field yang lain
            $table->timestamp('visit_time');
            $table->string('ip_address');
            $table->string('session_id');
            $table->string('cookie_id')->nullable();
            $table->string('user_agent');
            $table->string('device');
            $table->string('platform');
            $table->string('browser');
            
            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor');
    }
};
