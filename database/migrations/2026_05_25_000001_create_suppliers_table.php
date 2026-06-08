<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('org_id');
            $table->string('name');
            $table->string('contact_name')->nullable();
            $table->string('email', 191)->nullable();
            $table->string('phone', 50)->nullable();
            $table->text('address')->nullable();
            $table->string('country', 100)->nullable();
            $table->string('currency', 10)->default('USD');
            $table->string('status', 50)->default('Active');

            $table->foreign('org_id')
                ->references('idtbl_company')
                ->on('tbl_company')
                ->onDelete('cascade');

            $table->index(['org_id', 'name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
};
