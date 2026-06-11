<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::statement('DROP TABLE IF EXISTS `tbl_tray_box`');

        DB::statement("
            CREATE TABLE `tbl_tray_box` (
                `idtbl_tray_box`            INT(11)      NOT NULL AUTO_INCREMENT,
                `idtbl_storage_locations`   INT(11)      NOT NULL,
                `tray_box_number`           VARCHAR(50)  NOT NULL COLLATE utf8mb4_general_ci,
                `description`               VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_general_ci,
                `status`                    INT(11)      DEFAULT 1 COMMENT '1=Active, 2=Inactive, 0=Deleted',
                `insertuser`                INT(11)      DEFAULT NULL,
                `insertdatetime`            DATETIME     DEFAULT CURRENT_TIMESTAMP,
                `updateuser`                VARCHAR(50)  DEFAULT NULL COLLATE utf8mb4_unicode_ci,
                `updatedatetime`            DATETIME     DEFAULT NULL,

                PRIMARY KEY (`idtbl_tray_box`),
                INDEX `idx_idtbl_storage_locations` (`idtbl_storage_locations`),
                INDEX `idx_insertuser`              (`insertuser`),

                CONSTRAINT `fk_tray_box_storage_location`
                    FOREIGN KEY (`idtbl_storage_locations`)
                    REFERENCES `tbl_storage_locations` (`idtbl_storage_locations`),

                CONSTRAINT `fk_tray_box_user`
                    FOREIGN KEY (`insertuser`)
                    REFERENCES `tbl_user` (`idtbl_user`)
            ) ENGINE=InnoDB
              DEFAULT CHARSET=utf8mb4
              COLLATE=utf8mb4_general_ci;
        ");

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

    public function down(): void
    {
        DB::statement('DROP TABLE IF EXISTS `tbl_tray_box`');
    }
};
