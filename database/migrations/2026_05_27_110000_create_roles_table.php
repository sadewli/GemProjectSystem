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
        Schema::dropIfExists('tbl_role');
        Schema::create('tbl_role', function (Blueprint $table) {
            $table->increments('idtbl_role');
            $table->string('role_name', 100);    // e.g. Manager
            $table->string('value', 100);        // e.g. manager
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
        Schema::dropIfExists('tbl_role');
    }
};
