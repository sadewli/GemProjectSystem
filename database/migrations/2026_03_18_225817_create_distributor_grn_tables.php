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
        Schema::create('tbl_distributor_grn', function (Blueprint $table) {
            $table->increments('idtbl_grn');
            $table->string('grn_no', 45)->nullable();
            $table->date('date')->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->decimal('vatamount', 10, 2)->nullable();
            $table->decimal('nettotal', 10, 2)->nullable();
            $table->string('invoicenum', 45)->nullable();
            $table->string('dispatchnum', 45)->nullable();
            $table->string('batchno', 45)->nullable();
            $table->integer('porder_id')->nullable();
            $table->integer('distributor_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('confirm_status')->default(0);
            $table->tinyInteger('transfer_status')->default(0);
            $table->integer('updateuser')->nullable();
            $table->dateTime('updatedatetime')->nullable();
        });

        Schema::create('tbl_distributor_grndetail', function (Blueprint $table) {
            $table->increments('idtbl_grndetail');
            $table->date('date')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->decimal('qty', 10, 2)->nullable();
            $table->decimal('unitprice', 10, 2)->nullable();
            $table->decimal('saleprice', 10, 2)->nullable();
            $table->decimal('retailprice', 10, 2)->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->integer('grn_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->dateTime('insertdatetime')->nullable();
            $table->integer('updateuser')->nullable();
            $table->dateTime('updatedatetime')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_distributor_grndetail');
        Schema::dropIfExists('tbl_distributor_grn');
    }
};
