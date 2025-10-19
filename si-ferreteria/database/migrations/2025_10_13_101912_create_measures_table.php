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
        Schema::create('measures', function (Blueprint $table) {
            $table->id();
            $table->decimal('length', 10, 2)->nullable();
            $table->enum('length_unit', ['m', 'cm', 'mm', 'in'])->default('cm')->nullable();

            $table->decimal('width', 10, 2)->nullable();
            $table->enum('width_unit', ['m', 'cm', 'mm', 'in'])->default('cm')->nullable();

            $table->decimal('height', 10, 2)->nullable();
            $table->enum('height_unit', ['m', 'cm', 'mm', 'in'])->default('cm')->nullable();

            $table->decimal('thickness', 10, 2)->nullable();
            $table->enum('thickness_unit', ['mm', 'in', 'gauge'])->default('mm')->nullable();

            $table->timestamps();

            // Índice único para evitar duplicados
            $table->unique(['length', 'length_unit', 'width', 'width_unit', 'height', 'height_unit', 'thickness', 'thickness_unit'], 'measures_unique');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('measures');
    }
};
