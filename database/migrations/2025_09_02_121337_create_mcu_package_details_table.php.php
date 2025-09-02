<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('mcu_package_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mcu_package_id')->constrained()->onDelete('cascade');
            $table->foreignId('detail_department_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mcu_package_details');
    }
};
