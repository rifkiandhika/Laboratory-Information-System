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
        Schema::create('pemeriksaans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_parameter');
            $table->string('nama_pemeriksaan');
            $table->string('id_departement');
            $table->integer('harga');
            $table->timestamps();

            // // Cascade delete
            // $table->foreign('id_departement')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaans');
    }
};
