<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShippingInvoiceController extends Controller
{
    public function index()
    {
        return view('sales.shipping_invoices');
    }

    public function show($id = null)
    {
        return view('sales.shipping_invoice_detail');
    }
}
