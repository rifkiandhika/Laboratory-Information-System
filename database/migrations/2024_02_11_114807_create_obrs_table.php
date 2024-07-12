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
        Schema::create('obrs', function (Blueprint $table) {
            $table->id();
            $table->string('message_control_id')->nullable();
            $table->string('order_number')->nullable();
            $table->string('requested_time')->nullable();
            $table->string('examination_time')->nullable();
            $table->string('specimen_received_time')->nullable();
            $table->string('collector')->nullable();
            $table->string('result_time')->nullable();
            $table->string('service_segment')->nullable();
            $table->string('examiner')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obrs');
    }
};
