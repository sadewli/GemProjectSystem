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
        Schema::create('tbl_track_skuid', function (Blueprint $table) {
            $table->id();
            $table->integer('original_product_id');
            $table->integer('new_product_id');
            $table->unsignedBigInteger('production_sheet_id')->nullable();
            $table->string('change_type', 50)->nullable();
            $table->unsignedBigInteger('changed_by')->nullable();
            $table->dateTime('changed_date')->useCurrent();
            
            $table->foreign('original_product_id')->references('idtbl_products')->on('tbl_products')->onDelete('cascade');
            $table->foreign('new_product_id')->references('idtbl_products')->on('tbl_products')->onDelete('cascade');
        });

        Schema::create('tbl_lot_split', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_product_id');
            $table->integer('child_product_id');
            $table->integer('split_quantity');
            $table->decimal('split_weight_ct', 10, 3);
            $table->decimal('split_cost', 15, 2);
            $table->timestamps();

            $table->foreign('parent_product_id')->references('idtbl_products')->on('tbl_products')->onDelete('cascade');
            $table->foreign('child_product_id')->references('idtbl_products')->on('tbl_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lot_split_tables');
    }
};
