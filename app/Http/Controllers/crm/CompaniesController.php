<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function index()
    {
        return view('crm.companies');
    }

    public function import()
    {
        return view('crm.companies-import');
    }

}
