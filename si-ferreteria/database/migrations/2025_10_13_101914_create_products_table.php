<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->double('purchase_price', 10, 2);
            $table->enum('purchase_price_unit', ['USD', 'EUR', 'BOB',
                'ARS', 'CLP', 'COP', 'MXN', 'PEN',])->default('USD');
            $table->double('sale_price', 10, 2);
            $table->enum('sale_price_unit', ['USD', 'EUR', 'BOB',
                'ARS', 'CLP', 'COP', 'MXN', 'PEN',])->default('USD');
            $table->integer('input')->default(0);
            $table->integer('output')->default(0);
            $table->integer('stock')->default(0);
            $table->boolean('is_active')->default(true);
            $table->foreignId('category_id')->constrained()->onDelete('restrict');
            $table->foreignId('color_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('measure_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('volume_id')->nullable()->constrained()->onDelete('set null');
            $table->date('expiration_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
