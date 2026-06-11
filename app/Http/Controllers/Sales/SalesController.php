<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function invoice()
    {
        return view('sales.invoice');
    }

    public function invoices()
    {
        return view('sales.invoices');
    }

    public function customerMemo()
    {
        return view('sales.customer_memo');
    }
}
