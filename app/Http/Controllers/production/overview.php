<?php

namespace App\Http\Controllers\production;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class overview extends Controller
{
    public function index(Request $request)
    {
        // Mock production type options
        $productionTypes = [
            ['value' => 're-assortment', 'label' => 'Re-assortment'],
            ['value' => 'cutting',        'label' => 'Cutting'],
            ['value' => 're-cutting',     'label' => 'Re-cutting'],
            ['value' => 'product-transfer','label' => 'Product transfer'],
            ['value' => 'treatment',      'label' => 'Treatment'],
        ];

        // Mock creator options
        $creators = [
            ['value' => 'all',            'label' => 'All'],
            ['value' => 'created-by-me',  'label' => 'Created by me'],
        ];

        // Tab counts (will come from DB later)
        $counts = [
            'all'           => 0,
            'in_production' => 0,
            'completed'     => 0,
            'deleted'       => 0,
        ];

        // VEF totals per tab
        $totals = [
            'all'           => '0.00 VEF',
            'in_production' => '0.00 VEF',
            'completed'     => '0.00 VEF',
            'deleted'       => '0.00 VEF',
        ];

        return view('production.overview', compact(
            'productionTypes',
            'creators',
            'counts',
            'totals'
        ));
    }
}
