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
        Schema::create('loyalty_levels', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->comment('Código único del nivel (bronze, silver, gold, platinum, etc.)');
            $table->string('name')->comment('Nombre del nivel (Bronce, Plata, Oro, etc.)');
            $table->integer('min_points')->comment('Puntos mínimos requeridos para alcanzar este nivel');
            $table->decimal('multiplier', 4, 2)->default(1.0)->comment('Multiplicador de puntos para este nivel');
            $table->string('color')->nullable()->comment('Color hex para UI (#CD7F32)');
            $table->string('icon')->nullable()->comment('Emoji o ícono (🥉)');
            $table->integer('order')->default(0)->comment('Orden de visualización');
            $table->boolean('is_active')->default(true)->comment('Estado activo/inactivo');
            $table->timestamps();

            // Índices
            $table->index('order');
            $table->index('min_points');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_levels');
    }
};
