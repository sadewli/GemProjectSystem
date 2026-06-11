<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::statement('DROP TABLE IF EXISTS `tbl_shacut`');
        DB::statement('DROP TABLE IF EXISTS `tbl_shapes`');
        DB::statement('DROP TABLE IF EXISTS `tbl_cuts`');
        
        DB::statement("
            CREATE TABLE `tbl_shapes` (
                `idtbl_shapes`          INT(11)      NOT NULL AUTO_INCREMENT,
                `idtbl_product_types`   INT(11)      NOT NULL,
                `name`                  VARCHAR(100) NOT NULL COLLATE utf8mb4_general_ci,
                `status`                INT(11)      DEFAULT 1 COMMENT '1=Active, 2=Inactive, 0=Deleted',
                `insertuser`            INT(11)      DEFAULT NULL,
                `insertdatetime`        DATETIME     DEFAULT CURRENT_TIMESTAMP,
                `updateuser`            VARCHAR(50)  DEFAULT NULL COLLATE utf8mb4_unicode_ci,
                `updatedatetime`        DATETIME     DEFAULT NULL,

                PRIMARY KEY (`idtbl_shapes`),
                INDEX `idx_idtbl_product_types` (`idtbl_product_types`),
                INDEX `idx_insertuser`          (`insertuser`),

                CONSTRAINT `fk_shapes_product_type`
                    FOREIGN KEY (`idtbl_product_types`)
                    REFERENCES `tbl_product_types` (`idtbl_product_types`),

                CONSTRAINT `fk_shapes_user`
                    FOREIGN KEY (`insertuser`)
                    REFERENCES `tbl_user` (`idtbl_user`)
            ) ENGINE=InnoDB
              DEFAULT CHARSET=utf8mb4
              COLLATE=utf8mb4_general_ci;
        ");
        
        DB::statement("
            CREATE TABLE `tbl_cuts` (
                `idtbl_cuts`            INT(11)      NOT NULL AUTO_INCREMENT,
                `idtbl_product_types`   INT(11)      NOT NULL,
                `name`                  VARCHAR(100) NOT NULL COLLATE utf8mb4_general_ci,
                `status`                INT(11)      DEFAULT 1 COMMENT '1=Active, 2=Inactive, 0=Deleted',
                `insertuser`            INT(11)      DEFAULT NULL,
                `insertdatetime`        DATETIME     DEFAULT CURRENT_TIMESTAMP,
                `updateuser`            VARCHAR(50)  DEFAULT NULL COLLATE utf8mb4_unicode_ci,
                `updatedatetime`        DATETIME     DEFAULT NULL,

                PRIMARY KEY (`idtbl_cuts`),
                INDEX `idx_idtbl_product_types` (`idtbl_product_types`),
                INDEX `idx_insertuser`          (`insertuser`),

                CONSTRAINT `fk_cuts_product_type`
                    FOREIGN KEY (`idtbl_product_types`)
                    REFERENCES `tbl_product_types` (`idtbl_product_types`),

                CONSTRAINT `fk_cuts_user`
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
        DB::statement('DROP TABLE IF EXISTS `tbl_shapes`');
        DB::statement('DROP TABLE IF EXISTS `tbl_cuts`');
    }
};
