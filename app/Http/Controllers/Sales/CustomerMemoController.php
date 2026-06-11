<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class CustomerMemoController extends Controller
{
    public function index()
    {
        return view('sales.customer_memo');
    }

    public function show($id = null)
    {
        return view('sales.customer_memo_detail');
    }
}
