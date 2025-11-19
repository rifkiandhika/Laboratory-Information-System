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
        Schema::create('location_login_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('clinic_location_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('user_latitude', 10, 7);
            $table->decimal('user_longitude', 10, 7);
            $table->decimal('distance', 8, 2);
            $table->decimal('accuracy', 8, 2)->nullable();
            $table->boolean('login_allowed')->default(false);
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->text('failure_reason')->nullable();
            $table->timestamp('attempted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_login_logs');
    }
};
