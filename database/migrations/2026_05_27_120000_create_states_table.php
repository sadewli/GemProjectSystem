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
        Schema::dropIfExists('tbl_state');
        Schema::create('tbl_state', function (Blueprint $table) {
            $table->string('idtbl_state', 50)->primary();
            $table->string('state_name', 100);    // e.g. Western Province
            $table->string('value', 100);        // e.g. western_province
            $table->tinyInteger('status')->default(1); // 1 = Active, 0 = Inactive
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_state');
    }
};
