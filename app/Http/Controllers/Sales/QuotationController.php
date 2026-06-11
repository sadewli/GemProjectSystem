<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    public function index()
    {
        return view('sales.quotations');
    }

    public function show($id = null)
    {
        return view('sales.quotation_detail');
    }
}
