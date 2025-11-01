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
            $table->string('name');
            $table->string('slug')->unique(); // 'stripe', 'paypal', 'cash', etc.
            $table->string('provider')->nullable(); // nombre del gateway
            $table->json('credentials')->nullable(); // API keys encriptadas
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('requires_gateway')->default(false); // true para online, false para efectivo
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
