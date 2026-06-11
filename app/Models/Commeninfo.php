<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Commeninfo extends Model
{
    public function Getmenuprivilege()
    {
        $userID = Session::get('userid');
        $menuprivilegearray = [];

        $menus = DB::table('tbl_menu_list')
            ->select('idtbl_menu_list', 'menu_name')
            ->where('status', 1)
            ->get();

        foreach ($menus as $row) {
            $menucheckID = $row->idtbl_menu_list;
            $menuname = str_replace(' ', '_', $row->menu_name);

            $priv = DB::table('tbl_privilege')
                ->select('can_add', 'can_edit', 'can_statuschange', 'can_remove', 'access_status', 'tbl_menu_list_idtbl_menu_list')
                ->where('tbl_user_idtbl_user', $userID)
                ->where('tbl_menu_list_idtbl_menu_list', $menucheckID)
                ->where('status', 1)
                ->first();

            if ($priv) {
                $menuprivilegearray[] = (object) [
                    'add'          => $priv->can_add,
                    'edit'         => $priv->can_edit,
                    'statuschange' => $priv->can_statuschange,
                    'remove'       => $priv->can_remove,
                    'access_status'=> $priv->access_status,
                    'menuid'       => $priv->tbl_menu_list_idtbl_menu_list,
                    'menuname'     => $menuname,
                ];
            }
        }

        return $menuprivilegearray;
    }

    /**
     * Get organized menu structure grouped by category
     * Returns: ['category_name' => ['menu_id' => id, 'menu_name' => name, ...], ...]
     */
    public function GetOrganizedMenus()
    {
        $userID = Session::get('userid');
        $menus = $this->Getmenuprivilege();
        $menuIds = array_column($menus, 'menuid');

        // Define menu categories and their menu IDs
        $categories = [
            'Dashboard' => [1],
            'Inventory' => [5, 6, 7, 8, 9, 10, 11, 12, 13],
            'Sales & Purchases' => [14, 15, 16, 17, 18, 19, 20, 21],
            'CRM' => [22, 23],
            'Production' => [24, 25, 26, 27, 28, 29],
            'System Users' => [2, 3, 4],
            'Master Data' => [30, 31, 32, 33, 34, 35, 36, 37],
        ];

        $organizedMenus = [];
        
        foreach ($categories as $category => $categoryMenuIds) {
            $categoryItems = [];
            
            foreach ($categoryMenuIds as $menuId) {
                // Find menu from user privileges
                $menuItem = array_values(array_filter($menus, function ($item) use ($menuId) {
                    return $item->menuid == $menuId;
                }));
                
                if (!empty($menuItem)) {
                    $categoryItems[] = [
                        'menuid' => $menuItem[0]->menuid,
                        'menu_name' => $this->GetMenuNameById($menuItem[0]->menuid),
                        'menu_slug' => str_replace(' ', '_', $menuItem[0]->menuname),
                        'privileges' => $menuItem[0],
                    ];
                }
            }
            
            if (!empty($categoryItems)) {
                $organizedMenus[$category] = $categoryItems;
            }
        }

        return $organizedMenus;
    }

    /**
     * Get menu name by ID from database
     */
    private function GetMenuNameById($menuId)
    {
        $menu = DB::table('tbl_menu_list')
            ->where('idtbl_menu_list', $menuId)
            ->where('status', 1)
            ->first(['menu_name']);

        return $menu ? $menu->menu_name : '';
    }
}