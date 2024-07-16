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
        Schema::create('dokters', function (Blueprint $table) {
            $table->id();
            $table->string('kode_dokter');
            $table->string('nama_dokter');
            $table->string('id_poli');
            $table->string('no_telp');
            $table->string('email');
            $table->timestamps();

            
            // Cascade delete
            // $table->foreign('id_poli')->references('id')->on('dokters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokters');
    }
};
