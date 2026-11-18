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
        Schema::create('observation_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_code', 30)->unique();
            $table->string('session_name', 150);
            $table->foreignId('target_object_id')->constrained('target_objects')->restrictOnDelete();
            $table->date('observation_date');
            $table->enum('weather_condition', ['Cerah', 'Berawan Sebagian', 'Berkabut', 'Mendung']);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observation_sessions');
    }
};
