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
        Schema::create('loyalty_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loyalty_account_id')->constrained('loyalty_accounts')->onDelete('cascade');
            $table->enum('type', ['earn', 'redeem', 'expire', 'adjust'])->comment('Tipo de transacción');
            $table->integer('points')->comment('Cantidad de puntos (positivo para earn, negativo para redeem)');
            $table->integer('balance_after')->comment('Saldo después de la transacción');
            $table->text('description')->nullable();
            $table->string('reference_type')->nullable()->comment('Modelo relacionado (Sale, Redemption, etc)');
            $table->unsignedBigInteger('reference_id')->nullable()->comment('ID del modelo relacionado');
            $table->timestamp('expires_at')->nullable()->comment('Fecha de expiración (solo para puntos ganados)');
            $table->timestamps();

            // Índices
            $table->index('loyalty_account_id');
            $table->index('type');
            $table->index(['reference_type', 'reference_id']);
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_transactions');
    }
};
