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
        Schema::create('spesiment_handlings', function (Blueprint $table) {
            $table->id();
            $table->string('no_lab');
            $table->string('tabung');
            $table->string('serum');
            $table->string('status');
            $table->string('note')->nullable()->change();
            $table->dateTime('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spesiment_handlings');
    }
};
