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
        Schema::create('whitelisted_devices', function (Blueprint $table) {
            $table->id();
            $table->string('device_fingerprint', 50)->unique();
            $table->string('device_name', 100)->nullable();
            $table->foreignId('clinic_location_id')->nullable()->constrained()->onDelete('set null');
            $table->string('ip_address', 45)->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'revoked'])->default('pending');
            $table->boolean('is_active')->default(false);
            $table->timestamp('registered_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->unsignedBigInteger('registered_by')->nullable(); // User yang request
            $table->unsignedBigInteger('approved_by')->nullable(); // Admin yang approve
            $table->text('registration_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            $table->index('device_fingerprint');
            $table->index('status');
            $table->index('is_active');
            $table->index('clinic_location_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whitelisted_devices');
    }
};
