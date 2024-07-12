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
        Schema::create('mshes', function (Blueprint $table) {
            $table->id();
            $table->string('sender');
            $table->string('sender_facility');
            $table->string('sender_timestamp');
            $table->string('message_type');
            $table->string('message_control_id');
            $table->string('processing_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mshes');
    }
};
