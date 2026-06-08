<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        return view('sales.purchase_orders');
    }

    public function show($id = null)
    {
        return view('sales.purchase_order_detail');
    }
}
