<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuListAndPrivilegeSeeder extends Seeder
{
    /**
     * Seed the tbl_menu_list and tbl_privilege tables.
     * These are the 37 menus used by the Ceylon Center Gem system.
     * Admin user (id=1) gets full access to all menus.
     */
    public function run(): void
    {
        // ── 1. Menu List ────────────────────────────────────────────────────────
        $menus = [
            ['idtbl_menu_list' => 1,  'menu_name' => 'Dashboard',              'status' => 1],
            ['idtbl_menu_list' => 2,  'menu_name' => 'User Account',           'status' => 1],
            ['idtbl_menu_list' => 3,  'menu_name' => 'User Type',              'status' => 1],
            ['idtbl_menu_list' => 4,  'menu_name' => 'User Privilege',         'status' => 1],
            ['idtbl_menu_list' => 5,  'menu_name' => 'My Inventory',           'status' => 1],
            ['idtbl_menu_list' => 6,  'menu_name' => 'Memo In',                'status' => 1],
            ['idtbl_menu_list' => 7,  'menu_name' => 'Memo Out',               'status' => 1],
            ['idtbl_menu_list' => 8,  'menu_name' => 'Archived',               'status' => 1],
            ['idtbl_menu_list' => 9,  'menu_name' => 'Inventory List',         'status' => 1],
            ['idtbl_menu_list' => 10, 'menu_name' => 'Stock Take',             'status' => 1],
            ['idtbl_menu_list' => 11, 'menu_name' => 'Inventory Adjustment',   'status' => 1],
            ['idtbl_menu_list' => 12, 'menu_name' => 'Negative Inventory',     'status' => 1],
            ['idtbl_menu_list' => 13, 'menu_name' => 'Product Code',           'status' => 1],
            ['idtbl_menu_list' => 14, 'menu_name' => 'Invoice',                'status' => 1],
            ['idtbl_menu_list' => 15, 'menu_name' => 'Customer Memo',          'status' => 1],
            ['idtbl_menu_list' => 16, 'menu_name' => 'Quotation',              'status' => 1],
            ['idtbl_menu_list' => 17, 'menu_name' => 'Shipping Invoice',       'status' => 1],
            ['idtbl_menu_list' => 18, 'menu_name' => 'Transfer Documents',     'status' => 1],
            ['idtbl_menu_list' => 19, 'menu_name' => 'Purchase Order',         'status' => 1],
            ['idtbl_menu_list' => 20, 'menu_name' => 'Supplier Memo',          'status' => 1],
            ['idtbl_menu_list' => 21, 'menu_name' => 'Customer List',          'status' => 1],
            ['idtbl_menu_list' => 22, 'menu_name' => 'CRM Companies',          'status' => 1],
            ['idtbl_menu_list' => 23, 'menu_name' => 'CRM Contacts',           'status' => 1],
            ['idtbl_menu_list' => 24, 'menu_name' => 'Production Overview',    'status' => 1],
            ['idtbl_menu_list' => 25, 'menu_name' => 'Re-cutting',             'status' => 1],
            ['idtbl_menu_list' => 26, 'menu_name' => 'Cutting',                'status' => 1],
            ['idtbl_menu_list' => 27, 'menu_name' => 'Re-assortment',          'status' => 1],
            ['idtbl_menu_list' => 28, 'menu_name' => 'Treatment',              'status' => 1],
            ['idtbl_menu_list' => 29, 'menu_name' => 'Product Transfer',       'status' => 1],
            ['idtbl_menu_list' => 30, 'menu_name' => 'Variety',                'status' => 1],
            ['idtbl_menu_list' => 31, 'menu_name' => 'Sub-Category',           'status' => 1],
            ['idtbl_menu_list' => 32, 'menu_name' => 'Color',                  'status' => 1],
            ['idtbl_menu_list' => 33, 'menu_name' => 'Color Category',         'status' => 1],
            ['idtbl_menu_list' => 34, 'menu_name' => 'Shapes Cutting',         'status' => 1],
            ['idtbl_menu_list' => 35, 'menu_name' => 'Grades',                 'status' => 1],
            ['idtbl_menu_list' => 36, 'menu_name' => 'Origin Treatment',       'status' => 1],
            ['idtbl_menu_list' => 37, 'menu_name' => 'Storage Locations',      'status' => 1],
            ['idtbl_menu_list' => 44, 'menu_name' => 'Certificate Labs',       'status' => 1],
        ];

        // Skip if already seeded
        if (DB::table('tbl_menu_list')->count() === 0) {
            DB::table('tbl_menu_list')->insert($menus);
            $this->command->info('tbl_menu_list: ' . count($menus) . ' menus inserted.');
        } else {
            $this->command->info('tbl_menu_list: already has data, skipping.');
        }

        // ── 2. Privileges — Admin (user id=1) gets full access to all menus ──
        if (DB::table('tbl_privilege')->where('tbl_user_idtbl_user', 1)->count() === 0) {
            $privileges = [];
            foreach ($menus as $menu) {
                $privileges[] = [
                    'can_add'                       => 1,
                    'can_edit'                      => 1,
                    'can_statuschange'              => 1,
                    'can_remove'                    => 1,
                    'access_status'                 => 1,
                    'status'                        => 1,
                    'insertdatetime'                => now(),
                    'updateuser'                    => null,
                    'updatedatetime'                => null,
                    'tbl_user_idtbl_user'           => 1,
                    'tbl_menu_list_idtbl_menu_list' => $menu['idtbl_menu_list'],
                ];
            }
            DB::table('tbl_privilege')->insert($privileges);
            $this->command->info('tbl_privilege: ' . count($privileges) . ' privilege rows inserted for admin user.');
        } else {
            $this->command->info('tbl_privilege: admin already has privileges, skipping.');
        }
    }
}
