<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class memoin extends Controller
{
    public function index()
    {
        return view('inventory.memoin');
    }
}
