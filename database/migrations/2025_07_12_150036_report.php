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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('nolab');
            $table->bigInteger('id_parameter');
            $table->bigInteger('mcu_package_id')->nullable();
            $table->integer('department');
            $table->string('payment_method');
            $table->string('nama_parameter');
            $table->string('nama_dokter')->nullable();
            $table->integer('quantity');
            $table->dateTime('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
