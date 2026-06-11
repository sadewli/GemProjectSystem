<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        // We will drop the existing tbl_colors if it exists to replace it with the new schema
        DB::statement('DROP TABLE IF EXISTS `tbl_colors`');

        DB::statement("
            CREATE TABLE `tbl_colors` (
                `idtbl_colors`          INT(11)      NOT NULL AUTO_INCREMENT,
                `idtbl_product_types`   INT(11)      NOT NULL,
                `color_name`            VARCHAR(50)  NOT NULL COLLATE utf8mb4_general_ci,
                `hex_code`              VARCHAR(10)  DEFAULT NULL COLLATE utf8mb4_general_ci,
                `status`                INT(11)      DEFAULT 1 COMMENT '1=Active, 2=Inactive, 0=Deleted',
                `insertuser`            INT(11)      DEFAULT NULL,
                `insertdatetime`        DATETIME     DEFAULT CURRENT_TIMESTAMP,
                `updateuser`            VARCHAR(50)  DEFAULT NULL COLLATE utf8mb4_unicode_ci,
                `updatedatetime`        DATETIME     DEFAULT NULL,

                PRIMARY KEY (`idtbl_colors`),
                INDEX `idx_idtbl_product_types` (`idtbl_product_types`),
                INDEX `idx_insertuser`          (`insertuser`),

                CONSTRAINT `fk_colors_product_type`
                    FOREIGN KEY (`idtbl_product_types`)
                    REFERENCES `tbl_product_types` (`idtbl_product_types`),

                CONSTRAINT `fk_colors_user`
                    FOREIGN KEY (`insertuser`)
                    REFERENCES `tbl_user` (`idtbl_user`)
            ) ENGINE=InnoDB
              DEFAULT CHARSET=utf8mb4
              COLLATE=utf8mb4_general_ci;
        ");
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP TABLE IF EXISTS `tbl_colors`');
    }
};
