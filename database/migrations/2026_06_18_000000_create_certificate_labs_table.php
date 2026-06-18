<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tbl_certificate_labs', function (Blueprint $table) {
            $table->increments('idtbl_certificate_labs');
            $table->string('lab_name', 100)->collation('utf8mb4_general_ci');
            $table->integer('status')->default(1)->comment('1=Active, 2=Inactive, 0=Deleted');
            $table->integer('insertuser')->nullable();
            $table->dateTime('insertdatetime')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('updateuser', 50)->nullable()->collation('utf8mb4_unicode_ci');
            $table->dateTime('updatedatetime')->nullable();
            $table->index('insertuser', 'idx_insertuser');

            // Add foreign key if tbl_user exists
            // Some environments may require disabling foreign key checks when users table is not present.
            $table->foreign('insertuser')->references('idtbl_user')->on('tbl_user');
        });

        // Seed default labs
        DB::table('tbl_certificate_labs')->insert([
            ['lab_name' => 'GRS', 'insertuser' => 1],
            ['lab_name' => 'GIA', 'insertuser' => 1],
            ['lab_name' => 'SSEF', 'insertuser' => 1],
            ['lab_name' => 'Lotus', 'insertuser' => 1],
        ]);
    }

    public function down()
    {
        Schema::table('tbl_certificate_labs', function (Blueprint $table) {
            $table->dropForeign(['insertuser']);
        });
        Schema::dropIfExists('tbl_certificate_labs');
    }
};
