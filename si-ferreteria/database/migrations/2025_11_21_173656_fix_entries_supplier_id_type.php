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
        // Usamos DB::statement para PostgreSQL para poder hacer el cast explícito
        DB::statement('ALTER TABLE entries ALTER COLUMN supplier_id TYPE bigint USING supplier_id::bigint');
        
        // Opcional: Agregar la restricción de clave foránea si no existe
        // Schema::table('entries', function (Blueprint $table) {
        //     $table->foreign('supplier_id')->references('user_id')->on('suppliers');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->string('supplier_id')->change();
        });
    }
};
