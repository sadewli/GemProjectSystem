<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_state')->insert([
            [
                'idtbl_state' => 'WP',
                'idtbl_country' => 'SL',
                'state_name' => 'Western Province',
                'value' => 'western_province',
                'status' => 1,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idtbl_state' => 'CP',
                'idtbl_country' => 'SL',
                'state_name' => 'Central Province',
                'value' => 'central_province',
                'status' => 1,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idtbl_state' => 'SP',
                'idtbl_country' => 'SL',
                'state_name' => 'Southern Province',
                'value' => 'southern_province',
                'status' => 1,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idtbl_state' => 'NP',
                'idtbl_country' => 'SL',
                'state_name' => 'Northern Province',
                'value' => 'northern_province',
                'status' => 1,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idtbl_state' => 'EP',
                'idtbl_country' => 'SL',
                'state_name' => 'Eastern Province',
                'value' => 'eastern_province',
                'status' => 1,
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idtbl_state' => 'NWP',
                'idtbl_country' => 'SL',
                'state_name' => 'North Western Province',
                'value' => 'north_western_province',
                'status' => 1,
                'sort_order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idtbl_state' => 'NCP',
                'idtbl_country' => 'SL',
                'state_name' => 'North Central Province',
                'value' => 'north_central_province',
                'status' => 1,
                'sort_order' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idtbl_state' => 'UP',
                'idtbl_country' => 'SL',
                'state_name' => 'Uva Province',
                'value' => 'uva_province',
                'status' => 1,
                'sort_order' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idtbl_state' => 'SGP',
                'idtbl_country' => 'SL',
                'state_name' => 'Sabaragamuwa Province',
                'value' => 'sabaragamuwa_province',
                'status' => 1,
                'sort_order' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
