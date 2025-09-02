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
        Schema::create('detail_lots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quality_control_id')->constrained('quality_controls')->cascadeOnDelete();
            $table->string('parameter');
            $table->decimal('mean', 8, 2);
            $table->decimal('range', 8, 2);
            $table->decimal('bts_atas', 8, 2);
            $table->decimal('bts_bawah', 8, 2);
            $table->decimal('standart', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_lots');
    }
};
