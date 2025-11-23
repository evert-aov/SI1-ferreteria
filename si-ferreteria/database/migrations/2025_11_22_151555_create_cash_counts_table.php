<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cash_counts', function (Blueprint $table) {
            $table->id();
            
            // Relación con la caja
            $table->foreignId('cash_register_id')
                ->constrained('cash_registers')
                ->onDelete('cascade');
            
            // Saldo teórico del sistema
            $table->decimal('system_amount', 10, 2);
            
            // Conteo físico de billetes (Bolivia)
            $table->integer('bills_200')->default(0); // Billetes de 200 Bs
            $table->integer('bills_100')->default(0); // Billetes de 100 Bs
            $table->integer('bills_50')->default(0);  // Billetes de 50 Bs
            $table->integer('bills_20')->default(0);  // Billetes de 20 Bs
            $table->integer('bills_10')->default(0);  // Billetes de 10 Bs
            
            // Conteo físico de monedas (Bolivia)
            $table->integer('coins_5')->default(0);    // Monedas de 5 Bs
            $table->integer('coins_2')->default(0);    // Monedas de 2 Bs
            $table->integer('coins_1')->default(0);    // Monedas de 1 Bs
            $table->decimal('coins_050', 10, 2)->default(0); // Monedas de 0.50 Bs
            
            // Totales calculados
            $table->decimal('total_cash', 10, 2); // Total efectivo contado
            $table->decimal('total_cards', 10, 2)->default(0); // Total tarjetas
            $table->decimal('total_qr', 10, 2)->default(0); // Total QR
            $table->decimal('total_counted', 10, 2); // Total físico (cash + cards + qr)
            
            // Diferencia
            $table->decimal('difference', 10, 2); // Diferencia = total_counted - system_amount
            $table->decimal('difference_percentage', 5, 2)->nullable(); // Porcentaje
            
            // Justificación y estado
            $table->text('justification')->nullable();
            $table->enum('status', ['normal', 'with_difference', 'critical'])->default('normal');
            
            // Timestamps
            $table->timestamps();
            
            // Índices
            $table->index('cash_register_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_counts');
    }
};