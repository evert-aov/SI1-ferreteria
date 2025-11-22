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
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            
            // Customer and sale information
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('sale_id')->nullable()->constrained('sales')->onDelete('cascade');
            $table->foreignId('sale_unperson_id')->nullable()->constrained('sale_unpersons')->onDelete('cascade');
            $table->foreignId('sale_detail_id')->constrained('sale_details')->onDelete('cascade');
            
            // Claim details
            $table->enum('claim_type', ['defecto', 'devolucion', 'reembolso', 'garantia', 'otro'])->default('defecto');
            $table->text('description');
            $table->string('evidence_path')->nullable();
            
            // Status and management
            $table->enum('status', ['pendiente', 'en_revision', 'aprobada', 'rechazada'])->default('pendiente');
            $table->text('admin_notes')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
