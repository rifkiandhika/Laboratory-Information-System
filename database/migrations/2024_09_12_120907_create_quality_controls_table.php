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
        Schema::create('quality_controls', function (Blueprint $table) {
            $table->id();
            $table->string('no_lot');
            $table->string('name_control');
            $table->enum('level', ['low', 'normal', 'high']);
            $table->date('exp_date')->nullable();
            $table->date('use_qc')->nullable();
            $table->date('last_qc')->nullable();
            $table->string('department_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quality_controls');
    }
};
