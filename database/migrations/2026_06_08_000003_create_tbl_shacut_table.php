<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::statement('DROP TABLE IF EXISTS `tbl_shapes`');
        DB::statement('DROP TABLE IF EXISTS `tbl_shacut`');
        
        DB::statement("
            CREATE TABLE `tbl_shacut` (
                `idtbl_shacut`          INT(11)      NOT NULL AUTO_INCREMENT,
                `idtbl_product_types`   INT(11)      NOT NULL,
                `name`                  VARCHAR(100) NOT NULL COLLATE utf8mb4_general_ci,
                `type`                  INT(11)      NOT NULL COMMENT '1=Shape, 2=Cut',
                `status`                INT(11)      DEFAULT 1 COMMENT '1=Active, 2=Inactive, 0=Deleted',
                `insertuser`            INT(11)      DEFAULT NULL,
                `insertdatetime`        DATETIME     DEFAULT CURRENT_TIMESTAMP,
                `updateuser`            VARCHAR(50)  DEFAULT NULL COLLATE utf8mb4_unicode_ci,
                `updatedatetime`        DATETIME     DEFAULT NULL,

                PRIMARY KEY (`idtbl_shacut`),
                INDEX `idx_idtbl_product_types` (`idtbl_product_types`),
                INDEX `idx_insertuser`          (`insertuser`),

                CONSTRAINT `fk_shacut_product_type`
                    FOREIGN KEY (`idtbl_product_types`)
                    REFERENCES `tbl_product_types` (`idtbl_product_types`),

                CONSTRAINT `fk_shacut_user`
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
        DB::statement('DROP TABLE IF EXISTS `tbl_shacut`');
    }
};
