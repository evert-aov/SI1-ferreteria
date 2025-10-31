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
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->date('invoice_date');
            $table->enum('document_type', [
                'FACTURA',
                'NOTA_FISCAL',
                'RECIBO',
                'GUIA_REMISION',
                'NOTA_CREDITO',
                'NOTA_DEBITO',
                'ORDEN_COMPRA',
                'AJUSTE_INVENTARIO'
            ])->default('FACTURA');
            $table->decimal('total', 10, 2);

            $table->string('supplier_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
