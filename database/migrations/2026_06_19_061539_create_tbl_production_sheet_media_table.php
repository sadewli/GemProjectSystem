<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Run the exact DDL supplied in the project spec
        DB::statement("
            CREATE TABLE IF NOT EXISTS `tbl_production_sheet_media` (
              `idtbl_production_sheet_media` INT            NOT NULL AUTO_INCREMENT,
              `idtbl_production_sheets`      INT            NOT NULL,
              `file_type`                    ENUM('photo','document') NOT NULL,
              `file_name`                    VARCHAR(255)   NOT NULL,
              `original_name`               VARCHAR(255)   DEFAULT NULL,
              `file_path`                    VARCHAR(500)   NOT NULL,
              `mime_type`                    VARCHAR(100)   DEFAULT NULL,
              `file_size`                    BIGINT         DEFAULT NULL,
              `remarks`                      TEXT           DEFAULT NULL,
              `insertuser`                   INT            DEFAULT NULL,
              `insertdatetime`               DATETIME       DEFAULT CURRENT_TIMESTAMP,

              PRIMARY KEY (`idtbl_production_sheet_media`),

              KEY `idx_production_sheet` (`idtbl_production_sheets`),

              CONSTRAINT `fk_production_sheet_media`
                FOREIGN KEY (`idtbl_production_sheets`)
                REFERENCES `tbl_production_sheets` (`idtbl_production_sheets`)
                ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    }

    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('tbl_production_sheet_media');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
