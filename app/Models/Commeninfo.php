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
}