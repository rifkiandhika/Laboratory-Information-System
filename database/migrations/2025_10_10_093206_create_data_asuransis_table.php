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
        Schema::create('data_asuransis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('data_pasiens_id');
            $table->string('penjamin')->nullable();
            $table->bigInteger('no_penjamin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_asuransis');
    }
};
