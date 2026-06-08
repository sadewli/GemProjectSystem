<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Company;
use App\Models\CompanyBranch;

// avoid duplicate
$existing = Company::where('code','CCG')->first();
if ($existing) {
    echo "company_exists:{$existing->idtbl_company}\n";
    exit(0);
}

$c = Company::create(['company'=>'Ceylon Center Gem','code'=>'CCG','status'=>1]);
CompanyBranch::create(['tbl_company_idtbl_company'=>$c->idtbl_company,'branch'=>'Main Branch','code'=>'MAIN','status'=>1]);

echo "created_company_id:{$c->idtbl_company}\n";
