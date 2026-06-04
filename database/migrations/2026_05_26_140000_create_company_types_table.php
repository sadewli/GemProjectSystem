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
        Schema::dropIfExists('tbl_company_type');
        Schema::create('tbl_company_type', function (Blueprint $table) {
            $table->increments('idtbl_company_type');
            $table->string('company_type', 100); // e.g. Customer
            $table->string('value', 100);        // e.g. customer
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
        Schema::dropIfExists('tbl_company_type');
    }
};
