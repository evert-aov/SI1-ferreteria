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

            // Cliente (registrado)
            $table->foreignId('customer_id')->nullable()->constrained('users')->onDelete('cascade');


            // Dirección de envío
            $table->text('shipping_address');
            $table->string('shipping_city');
            $table->string('shipping_state');
            $table->string('shipping_zip')->nullable();
            $table->text('shipping_notes')->nullable();

            // Información de pago
            $table->foreignId('payment_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('payment_method', ['paypal', 'cash', 'bank_transfer', 'qr', 'card'])->default('cash');
            $table->string('payment_transaction_id')->nullable(); // ID de PayPal u otro gateway

            // Montos
            $table->decimal('subtotal', 10, 2);
            //$table->foreignId('discount_id')->nullable()->constrained('discounts')->onDelete('set null');
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->string('currency', 3)->default('USD');

            // Estado de la venta
            $table->enum('status', [
                'pending',      // Pendiente de pago
                'processing',   // Procesando
                'paid',         // Pagado
                'shipped',      // Enviado
                'delivered',    // Entregado
                'cancelled',    // Cancelado
                'refunded'      // Reembolsado
            ])->default('pending');

            // Notas y observaciones
            $table->text('notes')->nullable();
            $table->text('admin_notes')->nullable(); // Notas internas

            // Origen de la venta
            $table->enum('sale_type', ['online', 'pos', 'phone'])->default('online');

            // Timestamps
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
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
