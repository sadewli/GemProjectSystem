<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class import extends Controller
{
    public function index()
    {
        return view('layouts.import');
    }
}
