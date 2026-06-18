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
        Schema::create('tbl_partners', function (Blueprint $table) {
            $table->id('idtbl_partners');
            $table->string('partner_name', 255);
            $table->string('contact_name', 255)->nullable();
            $table->string('email', 191)->nullable();
            $table->string('phone', 50)->nullable();
            $table->text('address')->nullable();
            $table->string('country', 100)->nullable();
            $table->string('currency', 10)->nullable();
            $table->integer('status')->default(1)->comment('1=Active, 2=Inactive, 0=Deleted');
            $table->integer('insertuser')->nullable();
            $table->dateTime('insertdatetime')->useCurrent();
            $table->string('updateuser', 50)->nullable();
            $table->dateTime('updatedatetime')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_partners');
    }
};
