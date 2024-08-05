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
            $table->string('nama_parameter');
            $table->string('nama_pemeriksaan');
            $table->integer('harga');
            $table->string('nilai_statik');
            $table->string('nilai_satuan');
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
