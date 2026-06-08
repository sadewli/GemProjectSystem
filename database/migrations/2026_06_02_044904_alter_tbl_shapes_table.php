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
        if (!Schema::hasTable('tbl_shapes')) {
            Schema::create('tbl_shapes', function (Blueprint $table) {
                $table->id('idtbl_shapes');
                $table->unsignedBigInteger('org_id')->default(1);
                $table->enum('type', ['Shape', 'Cutting'])->default('Shape');
                $table->string('name', 100);
                $table->unsignedBigInteger('created_by')->nullable();
                $table->timestamp('insertdatetime')->useCurrent();
                $table->timestamp('updatedatetime')->useCurrent()->useCurrentOnUpdate();
                $table->foreign('org_id')->references('idtbl_company')->on('tbl_company')->onDelete('cascade');
            });
        } else {
            // If table exists, add missing columns
            Schema::table('tbl_shapes', function (Blueprint $table) {
                if (!Schema::hasColumn('tbl_shapes', 'org_id')) {
                    $table->unsignedBigInteger('org_id')->default(1)->after('idtbl_shapes');
                }
                if (!Schema::hasColumn('tbl_shapes', 'type')) {
                    $table->enum('type', ['Shape', 'Cutting'])->default('Shape')->after('org_id');
                }
                if (!Schema::hasColumn('tbl_shapes', 'name')) {
                    $table->string('name', 100)->after('type');
                }
                if (!Schema::hasColumn('tbl_shapes', 'created_by')) {
                    $table->unsignedBigInteger('created_by')->nullable()->after('name');
                }
                if (!Schema::hasColumn('tbl_shapes', 'insertdatetime')) {
                    $table->timestamp('insertdatetime')->useCurrent()->after('created_by');
                }
                if (!Schema::hasColumn('tbl_shapes', 'updatedatetime')) {
                    $table->timestamp('updatedatetime')->useCurrent()->useCurrentOnUpdate()->after('insertdatetime');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_shapes', function (Blueprint $table) {
            //
        });
    }
};
