<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tbl_login_log', function (Blueprint $table) {
            $table->increments('idtbl_login_log');
            $table->unsignedInteger('tbl_user_idtbl_user');
            $table->unsignedInteger('tbl_company_idtbl_company')->nullable();
            $table->unsignedInteger('tbl_company_branch_idtbl_company_branch')->nullable();
            $table->timestamp('login_datetime')->nullable();
            $table->timestamp('logout_datetime')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();

            $table->index('tbl_user_idtbl_user');
            $table->index('tbl_company_idtbl_company');
            $table->index('tbl_company_branch_idtbl_company_branch');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_login_log');
    }
};
