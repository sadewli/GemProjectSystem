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
        Schema::table('tbl_production_sheets', function (Blueprint $table) {
            $table->integer('supplier_id')->nullable()->after('creator_id');
            $table->index('supplier_id', 'idx_supplier_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_production_sheets', function (Blueprint $table) {
            $table->dropIndex('idx_supplier_id');
            $table->dropColumn('supplier_id');
        });
    }
};
