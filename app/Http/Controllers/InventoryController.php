<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductType;

class InventoryController extends Controller
{
    public function myinventory()
    {
        $productTypes = ProductType::all();
        return view('inventory.myinventory.myinventory', compact('productTypes'));
    }

    public function show($id = null)
    {
        $productTypes = ProductType::all();
        return view('inventory.myinventory.fullpage.fullpage.show', compact('productTypes'));
    }

    public function memoOut()
    {
        return view('inventory.memo_out');
    }
}
