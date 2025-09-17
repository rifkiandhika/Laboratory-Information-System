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
        Schema::create('hasil_pemeriksaans', function (Blueprint $table) {
            $table->id();
            $table->string('no_lab');
            $table->string('no_rm');
            $table->string('nama');
            $table->string('ruangan');
            $table->string('nama_dokter');
            $table->string('department')->nullable();
            $table->string('judul')->nullable();
            $table->string('nama_pemeriksaan');
            $table->string('hasil');
            $table->string('note')->nullable();
            $table->string('kesimpulan')->nullable();
            $table->string('saran')->nullable();
            $table->string('duplo_dx')->nullable();
            $table->string('duplo_d1')->nullable();
            $table->string('duplo_d2')->nullable();
            $table->string('duplo_d3')->nullable();
            $table->string('flag')->nullable();
            $table->string('satuan')->nullable();
            $table->string('range')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_pemeriksaans');
    }
};
