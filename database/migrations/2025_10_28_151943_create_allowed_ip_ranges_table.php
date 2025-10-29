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
        Schema::create('allowed_ip_ranges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinic_location_id')->constrained()->onDelete('cascade');
            $table->string('ip_range', 50); // e.g., "192.168.1." atau "10.0.0.0/24"
            $table->string('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index('clinic_location_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allowed_ip_ranges');
    }
};
