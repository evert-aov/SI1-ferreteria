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
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Vendedor
            $table->date('date'); // Fecha del registro
            $table->time('check_in_time')->nullable(); // Hora de entrada
            $table->time('check_out_time')->nullable(); // Hora de salida
            $table->enum('status', ['on_time', 'late', 'absent', 'present'])->default('absent');
            $table->text('notes')->nullable(); // Notas opcionales
            $table->timestamps();

            // Índice para búsquedas rápidas
            $table->index(['user_id', 'date']);
            $table->unique(['user_id', 'date']); // Un registro por vendedor por día
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};
