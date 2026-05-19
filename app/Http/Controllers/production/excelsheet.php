<?php

namespace App\Http\Controllers\production;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class excelsheet extends Controller
{
    public function index(Request $request)
    {
        $breadcrumbs = [
            ['label' => 'Excel upload',   'url' => route('production.excelsheet.index')],
            ['label' => 'Import type',    'url' => '#'],
            ['label' => 'Import category','url' => '#'],
        ];

        $categories = [
            [
                'name'  => 'Gemstones',
                'types' => [
                    ['key' => 're_assortment',    'label' => 'Re-assortment',   'icon' => 'reassortment'],
                    ['key' => 're_cutting_modal',  'label' => 'Re-Cutting',      'icon' => 'recutting'],
                    ['key' => 'product_transfer',  'label' => 'Product transfer','icon' => 'transfer'],
                    ['key' => 'treatment',         'label' => 'Treatment',       'icon' => 'treatment'],
                ],
            ],
            [
                'name'  => 'Diamonds',
                'types' => [
                    ['key' => 're_assortment',    'label' => 'Re-assortment',   'icon' => 'reassortment'],
                    ['key' => 're_cutting_modal',  'label' => 'Re-Cutting',      'icon' => 'recutting'],
                    ['key' => 'product_transfer',  'label' => 'Product transfer','icon' => 'transfer'],
                    ['key' => 'treatment',         'label' => 'Treatment',       'icon' => 'treatment'],
                ],
            ],
            [
                'name'  => 'Rough and Specimen',
                'types' => [
                    ['key' => 're_assortment',    'label' => 'Re-assortment',   'icon' => 'reassortment'],
                    ['key' => 'cutting',           'label' => 'Cutting',         'icon' => 'cutting'],
                    ['key' => 'product_transfer',  'label' => 'Product transfer','icon' => 'transfer'],
                    ['key' => 'treatment',         'label' => 'Treatment',       'icon' => 'treatment'],
                ],
            ],
        ];

        $templates = [
            'Products' => [
                'Gemstone',
                'Rough & Specimen',
                'Diamond',
                'Jewelry',
                'Gemstones on jewelry',
                'Diamonds on jewelry',
                'Jewelry components',
            ],
            'Contacts' => [
                'Companies',
                'Contacts',
            ],
            'Accounting documents' => [
                'Customer Invoices',
                'Purchase Orders',
                'Customer Memos',
                'Supplier Memos',
                'Transfer Documents',
            ],
            'Production' => [
                'Re-assortment',
                'Cutting (One to One)',
                'Cutting (Multiple to Multiple)',
                'Re-cutting (One to One)',
                'Re-cutting (Multiple to Multiple)',
                'Product transfer',
                'Treatment',
            ],
        ];

        return view('production.excelsheet', compact('breadcrumbs', 'categories', 'templates'));
    }
}
