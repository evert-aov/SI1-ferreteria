<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabla para registrar las salidas de productos del inventario
     * (productos vencidos, dañados o para uso de la empresa)
     */
    public function up(): void
    {
        Schema::create('exit_notes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable() // Para salidas automáticas
                ->constrained('users')
                ->nullOnDelete();

            $table->enum('exit_type', ['expired', 'damaged', 'company_use']);

            $table->enum('source', ['manual', 'automatic'])
                ->default('manual');

            $table->text('reason')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exit_notes');
    }
};
