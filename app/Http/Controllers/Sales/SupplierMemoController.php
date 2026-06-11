<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupplierMemoController extends Controller
{
    public function index()
    {
        return view('sales.supplier_memos');
    }

    public function show($id = null)
    {
        return view('sales.supplier_memo_detail');
    }
}
