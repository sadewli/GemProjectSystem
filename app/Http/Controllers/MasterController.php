<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function variety()
    {
        return view('master.variety');
    }

    public function subcategory()
    {
        return view('master.subcategory');
    }

    public function color()
    {
        return view('master.color');
    }

    public function color_category()
    {
        return view('master.color_category');
    }

    public function shape_cut()
    {
        return view('master.shape_cut');
    }

    public function grade()
    {
        return view('master.grade');
    }

    public function origin_treatment()
    {
        return view('master.origin_treatment');
    }

    public function storage_location()
    {
        return view('master.storage_location');
    }
}
