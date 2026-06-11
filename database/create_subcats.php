<?php

use Illuminate\Support\Facades\DB;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    DB::statement('DROP TABLE IF EXISTS tbl_sub_categories');
    
    DB::statement("
    CREATE TABLE tbl_sub_categories (
        idtbl_sub_categories  INT(11)      NOT NULL AUTO_INCREMENT,
        idtbl_product_types   INT(11)      NOT NULL,
        sub_category_name     VARCHAR(100) NOT NULL COLLATE utf8mb4_general_ci,
        status                INT(11)      DEFAULT 1 COMMENT '1=Active, 2=Inactive, 0=Deleted',
        insertuser            INT(11)      DEFAULT NULL,
        insertdatetime        DATETIME     DEFAULT CURRENT_TIMESTAMP,
        updateuser            VARCHAR(50)  DEFAULT NULL COLLATE utf8mb4_unicode_ci,
        updatedatetime        DATETIME     DEFAULT NULL,

        PRIMARY KEY (idtbl_sub_categories),
        INDEX idx_idtbl_product_types (idtbl_product_types),
        INDEX idx_insertuser          (insertuser),

        CONSTRAINT fk_sub_categories_product_type
            FOREIGN KEY (idtbl_product_types)
            REFERENCES tbl_product_types (idtbl_product_types),

        CONSTRAINT fk_sub_categories_user
            FOREIGN KEY (insertuser)
            REFERENCES tbl_user (idtbl_user)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ");
    echo "Table created successfully.\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
