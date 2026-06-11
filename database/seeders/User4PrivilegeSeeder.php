<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class User4PrivilegeSeeder extends Seeder
{
    /**
     * Set privileges for user ID 4 with Inventory and Sales items
     */
    public function run(): void
    {
        $userId = 4;

        // Menu IDs for Inventory and Sales items
        $inventoryMenuIds = [5, 6, 7, 8, 9, 10, 11, 12, 13];   // Inventory menus
        $salesMenuIds = [14, 15, 16, 17, 18, 19, 20, 21];      // Sales & Purchases menus

        // Combine both sets
        $allowedMenuIds = array_merge($inventoryMenuIds, $salesMenuIds);

        // Check if user 4 already has privileges
        $existingPrivileges = DB::table('tbl_privilege')
            ->where('tbl_user_idtbl_user', $userId)
            ->count();

        if ($existingPrivileges > 0) {
            $this->command->info("User 4 already has privileges set. Skipping...");
            return;
        }

        // Create privileges for user 4 with Inventory and Sales menus
        $privileges = [];
        foreach ($allowedMenuIds as $menuId) {
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
                'tbl_user_idtbl_user'           => $userId,
                'tbl_menu_list_idtbl_menu_list' => $menuId,
            ];
        }

        // Insert privileges
        DB::table('tbl_privilege')->insert($privileges);
        
        $this->command->info("User 4: " . count($privileges) . " privilege rows inserted (Inventory + Sales items).");
        
        // Show summary
        $this->command->info("\nPrivilege Summary for User 4:");
        $this->command->info("├─ Inventory menus: " . count($inventoryMenuIds) . " items");
        $this->command->info("├─ Sales menus: " . count($salesMenuIds) . " items");
        $this->command->info("└─ Total: " . count($privileges) . " menu items");
    }
}
