<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Agregar seller_user_id a sales si no existe
        if (!Schema::hasColumn('sales', 'seller_user_id')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->foreignId('seller_user_id')
                    ->nullable()
                    ->after('customer_id')
                    ->constrained('users')
                    ->onDelete('set null');
            });
        }

        // Agregar buyer_user_id a entries si no existe
        if (!Schema::hasColumn('entries', 'buyer_user_id')) {
            Schema::table('entries', function (Blueprint $table) {
                $table->foreignId('buyer_user_id')
                    ->nullable()
                    ->after('supplier_id')
                    ->constrained('users')
                    ->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            if (Schema::hasColumn('sales', 'seller_user_id')) {
                $table->dropForeign(['seller_user_id']);
                $table->dropColumn('seller_user_id');
            }
        });

        Schema::table('entries', function (Blueprint $table) {
            if (Schema::hasColumn('entries', 'buyer_user_id')) {
                $table->dropForeign(['buyer_user_id']);
                $table->dropColumn('buyer_user_id');
            }
        });
    }
};