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
        Schema::create('detail_departments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id');
            $table->string('kode');
            $table->string('id_pemeriksaan')->nullable();
            $table->string('nama_parameter');
            $table->string('nama_pemeriksaan');
            $table->string('jasa_sarana')->nullable();
            $table->string('jasa_pelayanan')->nullable();
            $table->string('jasa_dokter')->nullable();
            $table->string('jasa_bidan')->nullable();
            $table->string('jasa_perawat')->nullable();
            $table->integer('harga');
            $table->string('nilai_rujukan');
            $table->string('nilai_satuan')->nullable();
            $table->string('tipe_inputan');
            $table->string('opsi_output');
            $table->string('urutan')->nullable();
            $table->string('status')->default('deactive');
            $table->string('permission')->default('deactive');
            $table->timestamps();

            // // Cascade delete
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_departments');
    }
};
