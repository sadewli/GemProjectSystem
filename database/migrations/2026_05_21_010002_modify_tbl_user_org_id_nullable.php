<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Make org_id nullable with default NULL to avoid insert errors when not provided
        DB::statement("ALTER TABLE `tbl_user` MODIFY `org_id` INT NULL DEFAULT NULL;");
    }

    public function down()
    {
        // Revert to NOT NULL with default 0 (best-effort)
        DB::statement("ALTER TABLE `tbl_user` MODIFY `org_id` INT NOT NULL DEFAULT 0;");
    }
};
