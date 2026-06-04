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
        Schema::dropIfExists('tbl_country');
        Schema::create('tbl_country', function (Blueprint $table) {
            $table->string('idtbl_country', 50)->primary();
            $table->string('country_name', 100);
            $table->string('value', 100);
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
        Schema::dropIfExists('tbl_country');
    }
};
