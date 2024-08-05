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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->string('no_lab');
            $table->string('petugas');
            $table->string('no_pasien')->nullable();
            $table->string('metode_pembayaran');
            $table->integer('total_pembayaran_asli');
            $table->integer('total_pembayaran');
            $table->integer('jumlah_bayar');
            $table->integer('diskon')->nullable();
            $table->integer('kembalian');
            $table->dateTime('tanggal_pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
