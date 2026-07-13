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
        Schema::table('tbl_products', function (Blueprint $table) {
            $table->enum('inventory_type', ['individual', 'lot'])
                  ->default('individual')
                  ->comment('individual = Single item, lot = Bulk lot')
                  ->after('sku_number');
            $table->index('inventory_type', 'idx_inventory_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_products', function (Blueprint $table) {
            $table->dropIndex('idx_inventory_type');
            $table->dropColumn('inventory_type');
        });
    }
};
