<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$sql = file_get_contents(__DIR__.'/database_update.sql');
\Illuminate\Support\Facades\DB::unprepared($sql);
echo "SQL executed successfully.\n";
