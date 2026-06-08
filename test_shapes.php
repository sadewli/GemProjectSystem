<?php
// Simple test to check if the CRUD system works

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

// Test if we can query the shapes table
try {
    $shapes = DB::table('tbl_shapes')->get();
    echo "✓ tbl_shapes table exists!\n";
    echo "Records: " . count($shapes) . "\n";
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
