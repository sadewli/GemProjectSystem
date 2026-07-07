<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE tbl_products
            ADD COLUMN inventorystatus INT(11) NOT NULL DEFAULT 1 
                COMMENT '1=in, 2=out, 0=Deleted' 
                AFTER status,
            ADD COLUMN productionmanagetype INT(11) DEFAULT NULL 
                COMMENT '1=Re-assortment, 2=Cutting, 3=Re-cutting, 4=Product transfer, 5=Treatment' 
                AFTER inventorystatus
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_products', function (Blueprint $table) {
            $table->dropColumn(['inventorystatus', 'productionmanagetype']);
        });
    }
};
