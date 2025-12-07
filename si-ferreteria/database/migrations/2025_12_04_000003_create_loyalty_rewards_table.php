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
        Schema::create('loyalty_rewards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('points_cost')->comment('Costo en puntos');
            $table->enum('reward_type', ['discount_percentage', 'discount_amount', 'free_product']);
            $table->decimal('reward_value', 10, 2)->comment('Valor del descuento o ID del producto');
            $table->boolean('is_active')->default(true);
            $table->integer('stock_limit')->nullable()->comment('Límite de canjes disponibles');
            $table->integer('available_count')->nullable()->comment('Canjes restantes');
            $table->enum('minimum_level', ['bronze', 'silver', 'gold'])->default('bronze');
            $table->string('image')->nullable();
            $table->timestamps();

            // Índices
            $table->index('is_active');
            $table->index('minimum_level');
            $table->index('points_cost');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_rewards');
    }
};
