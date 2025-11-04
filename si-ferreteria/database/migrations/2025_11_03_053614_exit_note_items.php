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
        Schema::create('exit_note_items', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->unsignedBigInteger('exit_note_id');
            $table->unsignedBigInteger('product_id');

            // Información del detalle
            $table->integer('quantity')->unsigned();
            $table->string('reason'); // vencido, dañado, etc.

            $table->timestamps();

            // Llaves foráneas
            $table->foreign('exit_note_id')
                ->references('id')->on('exit_notes')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exit_note_items');
    }
};
