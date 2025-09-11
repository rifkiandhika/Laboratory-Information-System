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
        Schema::create('pemeriksaan_pasiens', function (Blueprint $table) {
            $table->id();
            $table->string('no_lab');
            $table->text('id_parameter');
            $table->unsignedBigInteger('mcu_package_id')->nullable();
            $table->text('id_departement')->nullable();
            $table->text('nama_parameter')->nullable();
            $table->integer('harga');
            $table->string('status')->default('baru')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_pasiens');
    }
};
