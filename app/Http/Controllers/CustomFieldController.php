<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomFieldController extends Controller
{
    public function index()
    {
        $customFields = DB::table('tbl_custom_fields')
            ->leftJoin('tbl_product_types', 'tbl_custom_fields.idtbl_product_types', '=', 'tbl_product_types.idtbl_product_types')
            ->where('tbl_custom_fields.status', '!=', 0)
            ->select('tbl_custom_fields.*', 'tbl_product_types.name as type_name')
            ->orderBy('tbl_custom_fields.idtbl_custom_fields', 'desc')
            ->get();

        $productTypes = DB::table('tbl_product_types')->where('status', 1)->get();

        return view('inventory.customfields.index', compact('customFields', 'productTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'field_name' => 'required|string|max:100',
            'field_type' => 'required|string',
            'idtbl_product_types' => 'required|integer',
        ]);

        $options = [];
        if ($request->field_type === 'dropdown' && $request->has('options')) {
            $options = array_filter($request->options);
        }

        DB::table('tbl_custom_fields')->insert([
            'field_name' => $request->field_name,
            'field_description' => $request->field_description,
            'field_type' => $request->field_type,
            'idtbl_product_types' => $request->idtbl_product_types,
            'field_options' => json_encode($options),
            'is_required' => $request->has('is_required') ? 1 : 0,
            'show_in_list' => 1,
            'show_in_search' => 0,
            'sort_order' => 0,
            'status' => 1,
            'insertuser' => \Session::get('userid') ?: 1,
            'insertdatetime' => now(),
        ]);

        return redirect()->back()->with('success', 'Custom field created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'field_name' => 'required|string|max:100',
            'field_type' => 'required|string',
            'idtbl_product_types' => 'required|integer',
        ]);

        $options = [];
        if ($request->field_type === 'dropdown' && $request->has('options')) {
            $options = array_filter($request->options);
        }

        DB::table('tbl_custom_fields')
            ->where('idtbl_custom_fields', $id)
            ->update([
                'field_name' => $request->field_name,
                'field_description' => $request->field_description,
                'field_type' => $request->field_type,
                'idtbl_product_types' => $request->idtbl_product_types,
                'field_options' => json_encode($options),
                'is_required' => $request->has('is_required') ? 1 : 0,
                'updateuser' => \Session::get('userid') ?: 1,
                'updatedatetime' => now(),
            ]);

        return redirect()->back()->with('success', 'Custom field updated successfully.');
    }

    public function destroy($id)
    {
        DB::table('tbl_custom_fields')
            ->where('idtbl_custom_fields', $id)
            ->update(['status' => 0]);

        return redirect()->back()->with('success', 'Custom field deleted successfully.');
    }
}
