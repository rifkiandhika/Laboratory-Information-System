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
        Schema::create('qc_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('qc_id');
            $table->string('parameter');
            $table->date('test_date');
            $table->decimal('d1', 10, 2)->nullable();
            $table->decimal('d2', 10, 2)->nullable();
            $table->decimal('d3', 10, 2)->nullable();
            $table->decimal('d4', 10, 2)->nullable();
            $table->decimal('d5', 10, 2)->nullable();
            $table->decimal('result', 10, 2);
            $table->string('flag')->default('Normal');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('qc_id')->references('id')->on('quality_controls')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            // Indexes untuk performa
            $table->index(['qc_id', 'parameter']);
            $table->index(['test_date']);
            $table->index(['parameter']);
            $table->index(['flag']);

            // Unique constraint untuk mencegah duplicate entry per hari
            $table->unique(['qc_id', 'parameter', 'test_date'], 'unique_qc_parameter_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qc_results');
    }
};
