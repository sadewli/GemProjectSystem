<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class inventorylist extends Controller
{
    public function index()
    {
        $products = DB::table('tbl_products as p')
            ->leftJoin('tbl_product_types as pt', 'p.idtbl_product_types', '=', 'pt.idtbl_product_types')
            ->leftJoin('tbl_varieties as v', 'p.idtbl_varieties', '=', 'v.idtbl_varieties')
            ->leftJoin('tbl_colors as c', 'p.idtbl_colors', '=', 'c.idtbl_colors')
            ->leftJoin('tbl_shapes as s', 'p.idtbl_shapes', '=', 's.idtbl_shapes')
            ->leftJoin('tbl_product_pricing as pr', 'p.idtbl_products', '=', 'pr.idtbl_products')
            ->leftJoin('tbl_product_purchasing as pu', 'p.idtbl_products', '=', 'pu.idtbl_products')
            ->leftJoin('tbl_weight_units as wu', 'pr.idtbl_weight_units', '=', 'wu.idtbl_weight_units')
            ->leftJoin('tbl_suppliers as sup', 'pu.idtbl_suppliers', '=', 'sup.idtbl_suppliers')
            ->leftJoin('tbl_ownership_type as ot', 'pu.idtbl_ownership_type', '=', 'ot.idtbl_ownership_type')
            ->select(
                'p.*',
                'pt.name as type_name',
                'v.name as variety_name',
                'c.color_name as color_name',
                's.name as shape_name',
                'pr.weight',
                'pr.quantity as pricing_quantity',
                'pr.cost_per_unit',
                'pr.total_cost',
                'pr.wholesale_price_per_unit',
                'pr.retail_price_per_unit',
                'wu.unit_name as weight_unit',
                'sup.supplier_name',
                'ot.ownership_type_name',
                'pu.date_of_purchase'
            )
            ->where('p.status', 1)
            ->orderBy('p.idtbl_products', 'desc')
            ->get();

        return view('inventory.inventorylist', compact('products'));
    }
}
