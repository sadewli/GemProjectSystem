<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_storage_locations', function (Blueprint $table) {
            $table->id();
            $table->string('location_name', 100);
            $table->string('short_code', 20);
            $table->unsignedBigInteger('branch_id');
            $table->string('contact_person', 100)->nullable();
            $table->unsignedBigInteger('org_id');
            // No timestamps as the original models use $timestamps = false
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_storage_locations');
    }
};
