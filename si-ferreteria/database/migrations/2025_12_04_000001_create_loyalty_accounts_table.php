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
        Schema::create('loyalty_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->integer('total_points_earned')->default(0)->comment('Total histórico de puntos ganados');
            $table->integer('available_points')->default(0)->comment('Puntos disponibles para canje');
            $table->enum('membership_level', ['bronze', 'silver', 'gold'])->default('bronze');
            $table->timestamp('level_updated_at')->nullable();
            $table->timestamps();

            // Índices
            $table->unique('customer_id');
            $table->index('membership_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_accounts');
    }
};
