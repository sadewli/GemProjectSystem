<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocationTransferController extends Controller
{
    public function index()
    {
        return view('sales.location_transfer');
    }

    public function show($id = null)
    {
        return view('sales.location_transfer_detail');
    }
}
