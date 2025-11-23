<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cash_registers', function (Blueprint $table) {
            $table->id();
            
            // Usuario responsable de la caja
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            
            // Fechas de apertura y cierre
            $table->timestamp('opened_at')->useCurrent();
            $table->timestamp('closed_at')->nullable();
            
            // Montos
            $table->decimal('opening_amount', 10, 2); // Monto inicial
            $table->decimal('closing_amount_system', 10, 2)->nullable(); // Saldo teórico
            $table->decimal('closing_amount_real', 10, 2)->nullable(); // Saldo físico contado
            $table->decimal('difference', 10, 2)->nullable(); // Diferencia
            
            // ❌ NO USAR STATUS - Se determina por closed_at
            // El modelo usa un accessor virtual para 'status'
            
            // Observaciones
            $table->text('opening_notes')->nullable();
            $table->text('closing_notes')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Índices
            $table->index('user_id');
            $table->index('opened_at');
            $table->index('closed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_registers');
    }
};