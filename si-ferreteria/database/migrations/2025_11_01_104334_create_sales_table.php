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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique(); // Número de factura

            // Cliente (puede ser null para ventas rápidas)
            $table->foreignId('customer_id')->nullable()->constrained('users')->onDelete('cascade');

            // Dirección de envío (null si es recogida en tienda)
            $table->text('shipping_address')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_zip')->nullable();
            $table->string('shipping_country', 2)->default('BO'); // Código ISO
            $table->text('shipping_notes')->nullable();

            // Relación con pago (ELIMINAMOS los campos redundantes)
            $table->foreignId('payment_id')->nullable()->constrained('payments')->onDelete('set null');

            // Montos
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->string('discount_code')->nullable(); // Código de cupón aplicado
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->string('currency', 3)->default('USD');

            // Estado de la venta
            $table->enum('status', [
                'pending',      // Pendiente de pago
                'processing',   // Procesando
                'paid',         // Pagado
                'preparing',    // Preparando pedido
                'shipped',      // Enviado
                'delivered',    // Entregado
                'cancelled',    // Cancelado
                'refunded'      // Reembolsado
            ])->default('pending');

            // Notas
            $table->text('notes')->nullable(); // Notas del cliente
            $table->text('admin_notes')->nullable(); // Notas internas

            // Origen de la venta
            $table->enum('sale_type', ['online', 'pos', 'phone', 'whatsapp'])->default('online');

            // Información de envío
            $table->string('shipping_method')->nullable(); // 'standard', 'express', 'pickup'
            $table->string('tracking_number')->nullable(); // Número de seguimiento
            $table->string('carrier')->nullable(); // Empresa de envío

            // Timestamps importantes
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('preparing_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
