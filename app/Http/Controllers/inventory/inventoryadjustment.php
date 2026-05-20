<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class inventoryadjustment extends Controller
{
    public function index()
    {
        return view('inventory.inventoryadjustment');
    }

    public function show($id)
    {
        // Add logic to show a specific adjustment
        return view('inventory.inventoryadjustment', compact('id'));
    }

    public function restore($id)
    {
        // Add logic to restore a specific adjustment
        return back()->with('success', 'Adjustment restored successfully');
    }
}
