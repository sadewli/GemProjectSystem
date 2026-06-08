<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tbl_company', function (Blueprint $table) {
            $table->increments('idtbl_company');
            $table->string('company');
            $table->string('code')->nullable();
            $table->tinyInteger('status')->default(1);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_company');
    }
};
