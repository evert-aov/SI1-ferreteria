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
        Schema::create('sale_unpersons', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique(); // nroFactura
            $table->foreignId('customer_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('payment_id')->nullable()->constrained()->onDelete('restrict');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->enum('status', ['draft', 'pending_payment', 'paid', 'cancelled'])->default('draft');
            $table->text('notes')->nullable();
            $table->foreignId('sale_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            $table->string('transaction_reference')->nullable()->after('transaction_id');
            $table->timestamp('payment_date')->nullable()->after('paid_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_unpersons');
    }
};
