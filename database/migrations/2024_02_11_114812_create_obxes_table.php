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
        Schema::create('obxes', function (Blueprint $table) {
            $table->id();
            $table->string('message_control_id')->nullable();
            $table->string('identifier_id')->nullable();
            $table->string('identifier_name')->nullable();
            $table->string('identifier_encode')->nullable();
            $table->string('identifier_value')->nullable();
            $table->string('identifier_unit')->nullable();
            $table->string('identifier_range')->nullable();
            $table->string('identifier_flags')->nullable();
            $table->string('status')->nullable();
            $table->string('tanggal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obxes');
    }
};
