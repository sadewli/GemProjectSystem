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
        Schema::create('tbl_product_types', function (Blueprint $table) {
            $table->bigIncrements('idtbl_product_types');
            $table->unsignedBigInteger('idtbl_skus');
            $table->string('name', 100);
            $table->string('skuname', 50);
            $table->integer('status')->default(1)->comment('1=Active, 2=Inactive, 0=Deleted');
            $table->integer('insertuser')->nullable();
            $table->timestamp('insertdatetime')->useCurrent();
            $table->string('updateuser', 50)->nullable();
            $table->timestamp('updatedatetime')->nullable();

            $table->foreign('idtbl_skus')
                ->references('idtbl_skus')
                ->on('tbl_skus')
                ->onDelete('cascade');

            $table->foreign('insertuser')
                ->references('idtbl_user')
                ->on('tbl_user')
                ->onDelete('set null');

            $table->index('idtbl_skus');
            $table->index('insertuser');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_product_types');
    }
};
