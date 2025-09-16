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
        Schema::create('pasiens', function (Blueprint $table) {
            $table->id();
            $table->string('no_lab');
            $table->string('no_rm')->nullable();
            $table->integer('cito')->default(0);
            $table->string('nik')->nullable();
            $table->string('jenis_pelayanan')->nullable();
            $table->string('nama');
            $table->date('lahir');
            $table->string('jenis_kelamin');
            $table->string('no_telp');
            $table->string('diagnosa')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kode_dokter')->nullable();
            $table->string('dokter_external')->nullable();
            $table->string('asal_ruangan')->nullable();
            $table->string('status')->default('Belum Dilayani');
            $table->dateTime('tanggal_masuk')->default(now());
            $table->string('tanggal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};
