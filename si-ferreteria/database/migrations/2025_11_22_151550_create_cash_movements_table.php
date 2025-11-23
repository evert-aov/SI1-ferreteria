<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cash_movements', function (Blueprint $table) {
            $table->id();
            
            // Relación con la caja
            $table->foreignId('cash_register_id')
                ->constrained('cash_registers')
                ->onDelete('cascade');
            
            // Tipo y concepto del movimiento
            $table->enum('type', ['income', 'expense']); // ingreso/egreso
            $table->enum('concept', ['sale', 'purchase', 'expense', 'withdrawal', 'deposit', 'other']);
            
            // Método de pago
            $table->enum('payment_method', ['cash', 'credit_card', 'debit_card', 'qr']);
            
            // Monto y descripción
            $table->decimal('amount', 10, 2);
            $table->text('description');
            
            // Relaciones opcionales (si viene de venta o compra)
            $table->foreignId('sale_id')
                ->nullable()
                ->constrained('sales')
                ->onDelete('set null');
            
            $table->foreignId('entry_id')
                ->nullable()
                ->constrained('entries')
                ->onDelete('set null');
            
            // Timestamps
            $table->timestamps();
            
            // Índices
            $table->index('cash_register_id');
            $table->index('type');
            $table->index('concept');
            $table->index('payment_method');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_movements');
    }
};