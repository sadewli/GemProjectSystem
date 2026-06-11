<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tbl_company_branch', function (Blueprint $table) {
            $table->increments('idtbl_company_branch');
            $table->unsignedInteger('tbl_company_idtbl_company');
            $table->string('branch');
            $table->string('code')->nullable();
            $table->tinyInteger('status')->default(1);

            $table->foreign('tbl_company_idtbl_company')
                ->references('idtbl_company')->on('tbl_company')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_company_branch');
    }
};
