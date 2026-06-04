<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_country')->insert([
            [
                'idtbl_country' => 'SL',
                'country_name' => 'Sri Lanka',
                'value' => 'Sri Lanka',
                'status' => 1,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idtbl_country' => 'IN',
                'country_name' => 'India',
                'value' => 'India',
                'status' => 1,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idtbl_country' => 'US',
                'country_name' => 'United States',
                'value' => 'United States',
                'status' => 1,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idtbl_country' => 'GB',
                'country_name' => 'United Kingdom',
                'value' => 'United Kingdom',
                'status' => 1,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idtbl_country' => 'AU',
                'country_name' => 'Australia',
                'value' => 'Australia',
                'status' => 1,
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idtbl_country' => 'SG',
                'country_name' => 'Singapore',
                'value' => 'Singapore',
                'status' => 1,
                'sort_order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idtbl_country' => 'AE',
                'country_name' => 'United Arab Emirates',
                'value' => 'United Arab Emirates',
                'status' => 1,
                'sort_order' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
