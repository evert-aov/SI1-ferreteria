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
            $table->timestamp('level_updated_at')->nullable();
            $table->timestamps();

            $table->string('membership_level');
            $table->foreign('membership_level')
                  ->references('code')
                  ->on('loyalty_levels')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            // Índices
            $table->unique('customer_id');
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
