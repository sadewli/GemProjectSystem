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
        Schema::dropIfExists('tbl_phone_code');
        Schema::create('tbl_phone_code', function (Blueprint $table) {
            $table->string('idtbl_phone_code', 10)->primary(); // ISO 2-letter country code
            $table->string('country_name', 100);
            $table->string('phone_code', 50); // Calling code (e.g. +94, +1)
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
        Schema::dropIfExists('tbl_phone_code');
    }
};
