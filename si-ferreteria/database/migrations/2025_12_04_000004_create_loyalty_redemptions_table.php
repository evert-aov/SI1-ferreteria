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
        Schema::create('loyalty_redemptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loyalty_account_id')->constrained('loyalty_accounts')->onDelete('cascade');
            $table->foreignId('loyalty_reward_id')->constrained('loyalty_rewards')->onDelete('cascade');
            $table->integer('points_spent');
            $table->foreignId('sale_id')->nullable()->constrained('sales')->onDelete('set null');
            $table->enum('status', ['pending', 'applied', 'expired', 'cancelled'])->default('pending');
            $table->timestamp('expires_at')->nullable()->comment('Vencimiento del cupón generado');
            $table->string('code')->unique()->comment('Código de cupón generado (LOY-XXXXXX)');
            $table->timestamps();

            // Índices
            $table->index('loyalty_account_id');
            $table->index('status');
            $table->index('code');
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_redemptions');
    }
};
