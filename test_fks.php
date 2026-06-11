<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

DB::unprepared("SET FOREIGN_KEY_CHECKS=0;");
DB::unprepared("DROP TABLE IF EXISTS test_products;");
DB::unprepared("
CREATE TABLE test_products (
    idtbl_products INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idtbl_product_types INT(11) NOT NULL,
    idtbl_sub_categories INT(11) DEFAULT NULL,
    idtbl_varieties INT(11) DEFAULT NULL,
    idtbl_colors INT(11) DEFAULT NULL,
    idtbl_shapes INT(11) DEFAULT NULL,
    idtbl_cuts INT(11) DEFAULT NULL,
    idtbl_treatments INT(11) DEFAULT NULL,
    idtbl_origins INT(11) DEFAULT NULL,
    idtbl_color_grade INT(11) DEFAULT NULL,
    idtbl_cuttinggrade INT(11) DEFAULT NULL,
    idtbl_clarity_grade INT(11) DEFAULT NULL,
    idtbl_storage_locations INT(11) DEFAULT NULL,
    idtbl_tray_box INT(11) DEFAULT NULL,
    insertuser INT(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
");
DB::unprepared("SET FOREIGN_KEY_CHECKS=1;");

$fks = [
    "ALTER TABLE test_products ADD CONSTRAINT fk_test_pt FOREIGN KEY (idtbl_product_types) REFERENCES tbl_product_types (idtbl_product_types)",
    "ALTER TABLE test_products ADD CONSTRAINT fk_test_sc FOREIGN KEY (idtbl_sub_categories) REFERENCES tbl_sub_categories (idtbl_sub_categories)",
    "ALTER TABLE test_products ADD CONSTRAINT fk_test_var FOREIGN KEY (idtbl_varieties) REFERENCES tbl_varieties (idtbl_varieties)",
    "ALTER TABLE test_products ADD CONSTRAINT fk_test_col FOREIGN KEY (idtbl_colors) REFERENCES tbl_colors (idtbl_colors)",
    "ALTER TABLE test_products ADD CONSTRAINT fk_test_sha FOREIGN KEY (idtbl_shapes) REFERENCES tbl_shapes (idtbl_shapes)",
    "ALTER TABLE test_products ADD CONSTRAINT fk_test_cut FOREIGN KEY (idtbl_cuts) REFERENCES tbl_cuts (idtbl_cuts)",
    "ALTER TABLE test_products ADD CONSTRAINT fk_test_tre FOREIGN KEY (idtbl_treatments) REFERENCES tbl_treatments (idtbl_treatments)",
    "ALTER TABLE test_products ADD CONSTRAINT fk_test_ori FOREIGN KEY (idtbl_origins) REFERENCES tbl_origins (idtbl_origins)",
    "ALTER TABLE test_products ADD CONSTRAINT fk_test_cg FOREIGN KEY (idtbl_color_grade) REFERENCES tbl_color_grade (idtbl_color_grade)",
    "ALTER TABLE test_products ADD CONSTRAINT fk_test_cutg FOREIGN KEY (idtbl_cuttinggrade) REFERENCES tbl_cuttinggrade (idtbl_cuttinggrade)",
    "ALTER TABLE test_products ADD CONSTRAINT fk_test_cla FOREIGN KEY (idtbl_clarity_grade) REFERENCES tbl_clarity_grade (idtbl_clarity_grade)",
    "ALTER TABLE test_products ADD CONSTRAINT fk_test_sl FOREIGN KEY (idtbl_storage_locations) REFERENCES tbl_storage_locations (idtbl_storage_locations)",
    "ALTER TABLE test_products ADD CONSTRAINT fk_test_tb FOREIGN KEY (idtbl_tray_box) REFERENCES tbl_tray_box (idtbl_tray_box)",
    "ALTER TABLE test_products ADD CONSTRAINT fk_test_usr FOREIGN KEY (insertuser) REFERENCES tbl_user (idtbl_user)",
];

foreach ($fks as $fk) {
    try {
        DB::unprepared($fk);
        echo "SUCCESS: $fk\n";
    } catch (\Exception $e) {
        echo "FAILED: $fk\n";
    }
}
DB::unprepared("DROP TABLE test_products;");
