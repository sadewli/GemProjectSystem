<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = [
    'tbl_product_types', 'tbl_sub_categories', 'tbl_varieties', 'tbl_colors', 
    'tbl_shapes', 'tbl_cuts', 'tbl_treatments', 'tbl_origins', 'tbl_color_grade', 
    'tbl_cuttinggrade', 'tbl_clarity_grade', 'tbl_storage_locations', 'tbl_tray_box', 
    'tbl_ownership_type', 'tbl_skus', 'tbl_user'
];
$missing = [];
foreach($tables as $t) { 
    try { 
        DB::select('SHOW CREATE TABLE ' . $t); 
    } catch (\Exception $e) { 
        $missing[] = $t; 
    } 
}
print_r($missing);
