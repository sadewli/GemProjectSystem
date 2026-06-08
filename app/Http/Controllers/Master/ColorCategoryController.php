<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ColorCategoryController extends Controller
{
    public function index()
    {
        // Replaced by the new Color Grade page
        return redirect('Master/ColorGrade');
    }

    public function insertupdate(Request $request)
    {
        return redirect('Master/ColorGrade');
    }
}
