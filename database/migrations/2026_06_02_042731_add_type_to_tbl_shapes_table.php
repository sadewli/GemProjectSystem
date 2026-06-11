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
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_shapes');
    }
};
