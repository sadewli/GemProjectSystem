<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tbl_product_types', function (Blueprint $table) {
            $table->bigIncrements('idtbl_product_types');
            $table->unsignedInteger('idtbl_skus');
            $table->string('name', 100);
            $table->string('skuname', 50);
            $table->integer('status')->default(1)->comment('1=Active, 2=Inactive, 0=Deleted');
            $table->integer('insertuser')->nullable();
            $table->timestamp('insertdatetime')->useCurrent();
            $table->string('updateuser', 50)->nullable();
            $table->timestamp('updatedatetime')->nullable();
            $table->primary('idtbl_product_types');
            $table->index('idtbl_skus');
            $table->index('insertuser');
        });

        // Foreign keys
        Schema::table('tbl_product_types', function (Blueprint $table) {
            $table->foreign('idtbl_skus')
                  ->references('idtbl_skus')
                  ->on('tbl_skus')
                  ->onDelete('restrict');
            $table->foreign('insertuser')
                  ->references('idtbl_user')
                  ->on('tbl_user')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_product_types');
    }
};
