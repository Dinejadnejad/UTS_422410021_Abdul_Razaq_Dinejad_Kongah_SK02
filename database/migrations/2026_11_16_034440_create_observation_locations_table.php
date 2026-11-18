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
        Schema::create('observation_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('observation_session_id')->unique()->constrained('observation_sessions')->cascadeOnDelete();
            $table->string('location_name', 120);
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->integer('elevation_masl')->default(0);
            $table->unsignedTinyInteger('bortle_scale');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observation_locations');
    }
};
