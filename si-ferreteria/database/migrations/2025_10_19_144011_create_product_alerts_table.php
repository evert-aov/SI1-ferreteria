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
        Schema::create('product_alerts', function (Blueprint $table) {
            $table->id();

            // Alert type
            $table->enum('alert_type', [
                'upcoming_expiration',
                'expired',
                'low_stock',
                'promotion',
                'price_changed',
                'no_sales',
                'overstock',
                'out_of_stock'
            ]);

            // Threshold value (for stock, days, etc)
            $table->double('threshold_value')->nullable();

            // Custom message
            $table->text('message')->nullable();

            // Alert priority
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');

            // Alert status
            $table->enum('status', ['pending', 'read', 'ignored'])->default('pending');

            // Visibility by roles (JSON array)
            $table->json('visible_to')->default('["Administrador", "Vendedor", "Cliente", "Proveedor"]');

            // Relations
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('cascade');

            // Active/inactive status
            $table->boolean('active')->default(true);

            $table->timestamps();

            // Indexes to improve performance
            $table->index('alert_type');
            $table->index('status');
            $table->index('active');
            $table->index(['user_id', 'active']);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_alerts');
    }
};
