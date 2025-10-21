<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('entry_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('entry_id')
                ->constrained('entries')
                ->onDelete('cascade');

            $table->foreignId('product_id')
                ->constrained('products')
                ->onDelete('restrict');

            $table->decimal('price', 10, 2);
            $table->decimal('quantity', 10, 2);

            $table->decimal('subtotal', 10, 2);

            $table->timestamps();

            $table->index('entry_id');
            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entry_details');
    }
};
