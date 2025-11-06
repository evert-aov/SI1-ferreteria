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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 'PayPal', 'Efectivo', 'Transferencia'
            $table->string('slug')->unique(); // 'paypal', 'cash', 'bank_transfer'
            $table->string('provider')->nullable(); // 'stripe', 'paypal_api', null para métodos locales
            $table->json('credentials')->nullable(); // API keys encriptadas
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('requires_gateway')->default(false); // true para online, false para efectivo
            $table->integer('sort_order')->default(0); // Para ordenar en el frontend
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
