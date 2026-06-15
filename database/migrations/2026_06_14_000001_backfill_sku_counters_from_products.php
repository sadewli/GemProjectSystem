<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // For each product type, compute the maximum numeric suffix used in tbl_products.sku_number
        $productTypes = DB::table('tbl_product_types')->get();

        foreach ($productTypes as $pt) {
            $prefix = trim($pt->skuname ?? '');
            if (empty($prefix)) continue;

            // position where numeric suffix starts
            $pos = strlen($prefix) + 1; // SUBSTRING index is 1-based

            // Build raw expression to extract numeric suffix and cast to unsigned
            // We use NULLIF to avoid casting empty strings to 0 incorrectly
            $raw = "MAX(CAST(NULLIF(SUBSTRING(sku_number, $pos), '') AS UNSIGNED)) as maxnum";

            $row = DB::table('tbl_products')
                ->where('sku_number', 'like', $prefix . '%')
                ->select(DB::raw($raw))
                ->first();

            $maxNum = $row->maxnum ?? 0;
            $lastNumber = intval($maxNum ?: 0);

            // Insert or update sku_counters
            $existing = DB::table('sku_counters')->where('idtbl_product_types', $pt->idtbl_product_types)->first();
            if ($existing) {
                DB::table('sku_counters')->where('id', $existing->id)->update([
                    'last_number' => $lastNumber,
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('sku_counters')->insert([
                    'idtbl_product_types' => $pt->idtbl_product_types,
                    'last_number' => $lastNumber,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down()
    {
        // optional: do nothing on rollback
    }
};
