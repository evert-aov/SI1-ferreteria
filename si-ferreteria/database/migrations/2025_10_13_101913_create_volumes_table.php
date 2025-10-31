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
        Schema::create('volumes', function (Blueprint $table) {
            $table->id();
            $table->decimal('peso', 10, 2)->nullable();
            $table->enum('peso_unit', ['kg', 'g', 'lb', 'oz'])->default('kg')->nullable();

            $table->decimal('volume', 10, 2)->nullable();
            $table->enum('volume_unit', ['L', 'ml', 'gal', 'oz'])->default('L')->nullable();

            $table->timestamps();

            $table->unique(['peso', 'peso_unit', 'volume', 'volume_unit'], 'volumes_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volumes');
    }
};
