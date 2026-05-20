<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class negativeinventory extends Controller
{
    /**
     * Display the negative inventory adjustment page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('inventory.negativeinventory');
    }
}
