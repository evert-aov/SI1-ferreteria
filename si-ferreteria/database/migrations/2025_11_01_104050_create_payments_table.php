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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Relación con método de pago
            $table->foreignId('payment_method_id')->constrained('payment_methods')->onDelete('restrict');

            // Información de la transacción
            $table->string('transaction_id')->unique()->nullable(); // ID del gateway (PayPal, Stripe, etc)
            $table->string('reference_number')->nullable(); // Número de referencia manual (para transferencias)

            // Montos
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');

            // Estado del pago
            $table->enum('status', [
                'pending',      // Pendiente
                'processing',   // En proceso
                'completed',    // Completado
                'failed',       // Fallido
                'refunded',     // Reembolsado
                'cancelled'     // Cancelado
            ])->default('pending');

            // Respuesta del gateway (JSON completo)
            $table->json('gateway_response')->nullable();

            // Metadata adicional
            $table->text('notes')->nullable(); // Notas del cajero/admin
            $table->string('payment_proof')->nullable(); // URL de comprobante (para transferencias)

            // Timestamps
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->timestamps();

            // Índices
            $table->index('status');
            $table->index('paid_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
