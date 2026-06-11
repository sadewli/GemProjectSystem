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
        Schema::table('tbl_grades', function (Blueprint $table) {
            // Drop existing grade_type string column if it exists
            if (Schema::hasColumn('tbl_grades', 'grade_type')) {
                $table->dropColumn('grade_type');
            }
            // Add grade_type_id foreign key
            if (!Schema::hasColumn('tbl_grades', 'grade_type_id')) {
                $table->unsignedBigInteger('grade_type_id')->after('org_id');
                $table->foreign('grade_type_id')->references('idtbl_grade_types')->on('tbl_grade_types')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_grades', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_grades', 'grade_type_id')) {
                $table->dropForeign(['grade_type_id']);
                $table->dropColumn('grade_type_id');
            }
            if (!Schema::hasColumn('tbl_grades', 'grade_type')) {
                $table->string('grade_type', 100)->after('org_id');
            }
        });
    }
};
