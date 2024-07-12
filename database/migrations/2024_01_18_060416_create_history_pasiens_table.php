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
        Schema::create('history_pasiens', function (Blueprint $table) {
            $table->id();
            $table->string('no_lab');
            $table->string('proses');
            $table->string('tempat');
            $table->dateTime('waktu_proses');
            $table->text('note')->nullable;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_pasiens');
    }
};
