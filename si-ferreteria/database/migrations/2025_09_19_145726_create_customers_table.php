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
        Schema::create('customers', function (Blueprint $table) {
            $table->foreignId('user_id')->primary()->constrained()->onDelete('cascade');
            $table->enum('type', ['individual', 'company'])->default('individual');
            $table->decimal('credit_limit', 10, 2)->nullable();
            $table->decimal('special_discount', 5, 2)->nullable();
            $table->date('last_order_date')->nullable();
            $table->enum('credit_status', ['paid', 'pending', 'none'])->default('none');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
