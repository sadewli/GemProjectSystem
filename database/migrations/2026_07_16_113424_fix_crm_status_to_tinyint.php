<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── tbl_create_contact ──────────────────────────────────────────────
        // Step 1: add temp integer column
        Schema::table('tbl_create_contact', function (Blueprint $table) {
            $table->tinyInteger('status_int')->default(1)->after('status');
        });

        // Step 2: convert existing string values → integer
        DB::statement("
            UPDATE tbl_create_contact SET status_int =
                CASE
                    WHEN status = 'inactive' THEN 2
                    WHEN status = 'pending'  THEN 3
                    WHEN status = 'deleted'  THEN 0
                    WHEN status = '0'        THEN 0
                    WHEN status = '2'        THEN 2
                    WHEN status = '3'        THEN 3
                    ELSE 1
                END
        ");

        // Step 3: drop old varchar column
        Schema::table('tbl_create_contact', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        // Step 4: rename using MariaDB-compatible CHANGE COLUMN
        DB::statement('ALTER TABLE `tbl_create_contact` CHANGE `status_int` `status` TINYINT(1) NOT NULL DEFAULT 1');

        // ── tbl_create_company ──────────────────────────────────────────────
        Schema::table('tbl_create_company', function (Blueprint $table) {
            $table->tinyInteger('status_int')->default(1)->after('status');
        });

        DB::statement("
            UPDATE tbl_create_company SET status_int =
                CASE
                    WHEN status = 'inactive' THEN 2
                    WHEN status = 'pending'  THEN 3
                    WHEN status = 'deleted'  THEN 0
                    WHEN status = '0'        THEN 0
                    WHEN status = '2'        THEN 2
                    WHEN status = '3'        THEN 3
                    ELSE 1
                END
        ");

        Schema::table('tbl_create_company', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        DB::statement('ALTER TABLE `tbl_create_company` CHANGE `status_int` `status` TINYINT(1) NOT NULL DEFAULT 1');
    }

    public function down(): void
    {
        // Reverse: add varchar back for contacts
        Schema::table('tbl_create_contact', function (Blueprint $table) {
            $table->string('status_str', 50)->nullable()->after('status');
        });
        DB::statement("
            UPDATE tbl_create_contact SET status_str =
                CASE
                    WHEN status = 0 THEN 'deleted'
                    WHEN status = 2 THEN 'inactive'
                    WHEN status = 3 THEN 'pending'
                    ELSE 'active'
                END
        ");
        Schema::table('tbl_create_contact', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        DB::statement('ALTER TABLE `tbl_create_contact` CHANGE `status_str` `status` VARCHAR(50) NULL DEFAULT NULL');

        // Reverse: add varchar back for companies
        Schema::table('tbl_create_company', function (Blueprint $table) {
            $table->string('status_str', 50)->nullable()->after('status');
        });
        DB::statement("
            UPDATE tbl_create_company SET status_str =
                CASE
                    WHEN status = 0 THEN 'deleted'
                    WHEN status = 2 THEN 'inactive'
                    WHEN status = 3 THEN 'pending'
                    ELSE 'active'
                END
        ");
        Schema::table('tbl_create_company', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        DB::statement('ALTER TABLE `tbl_create_company` CHANGE `status_str` `status` VARCHAR(50) NOT NULL DEFAULT \'active\'');
    }
};
