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
        if (!Schema::hasTable('tbl_grade_types')) {
            Schema::create('tbl_grade_types', function (Blueprint $table) {
                $table->id('idtbl_grade_types');
                $table->unsignedInteger('org_id')->default(1);
                $table->string('type_name', 100);
                $table->text('description')->nullable();
                $table->unsignedBigInteger('created_by')->nullable();
                $table->timestamp('insertdatetime')->useCurrent();
                $table->timestamp('updatedatetime')->useCurrent()->useCurrentOnUpdate();
                $table->foreign('org_id')->references('idtbl_company')->on('tbl_company')->onDelete('cascade');
                $table->unique(['org_id', 'type_name']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_grade_types');
    }
};
