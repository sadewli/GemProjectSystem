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
        if (!Schema::hasTable('tbl_treatments')) {
            Schema::create('tbl_treatments', function (Blueprint $table) {
                $table->id('idtbl_treatments');
                $table->unsignedInteger('org_id')->default(1);
                $table->string('treatment_name', 100);
                $table->unsignedBigInteger('created_by')->nullable();
                $table->timestamp('insertdatetime')->useCurrent();
                $table->timestamp('updatedatetime')->useCurrent()->useCurrentOnUpdate();
                $table->foreign('org_id')->references('idtbl_company')->on('tbl_company')->onDelete('cascade');
                $table->unique(['org_id', 'treatment_name']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_treatments');
    }
};
