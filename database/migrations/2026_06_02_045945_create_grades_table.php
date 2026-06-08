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
        if (!Schema::hasTable('tbl_grades')) {
            Schema::create('tbl_grades', function (Blueprint $table) {
                $table->id('idtbl_grades');
                $table->unsignedInteger('org_id')->default(1);
                $table->string('grade_type', 100);
                $table->string('grade_value', 100);
                $table->unsignedBigInteger('created_by')->nullable();
                $table->timestamp('insertdatetime')->useCurrent();
                $table->timestamp('updatedatetime')->useCurrent()->useCurrentOnUpdate();
                $table->foreign('org_id')->references('idtbl_company')->on('tbl_company')->onDelete('cascade');
                $table->index(['grade_type', 'org_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_grades');
    }
};
