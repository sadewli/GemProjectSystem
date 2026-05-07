<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Archived extends Controller
{
    public function index()
    {
        // Pass an empty collection for now - can be replaced with actual data query later
        $archivedItems = collect();
        return view('inventory.archived', compact('archivedItems'));
    }
}
