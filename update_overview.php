<?php

$file = 'resources/views/inventory/myinventory/fullpage/fullpage/partials/_overview.blade.php';
$content = file_get_contents($file);

$replacements = [
    [
        'label' => 'SKU',
        'var' => 'skus',
        'name' => 'idtbl_skus',
        'item' => 'sku',
        'display' => 'prefix',
        'id' => 'idtbl_skus',
        'search' => '<div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Prefix</div>'
    ],
    [
        'label' => 'Sub-Category',
        'var' => 'subCategories',
        'name' => 'idtbl_sub_categories',
        'item' => 'subCategory',
        'display' => 'subcategory',
        'id' => 'idtbl_sub_categories',
        'search' => '<div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Unspecified</div>
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Natural</div>
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Synthetic</div>'
    ],
    [
        'label' => 'Variety',
        'var' => 'varieties',
        'name' => 'idtbl_varieties',
        'item' => 'variety',
        'display' => 'variety',
        'id' => 'idtbl_varieties',
        'search' => '<div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Select variety</div>
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Sapphire</div>
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Ruby</div>'
    ],
    [
        'label' => 'Color',
        'var' => 'colors',
        'name' => 'idtbl_colors',
        'item' => 'color',
        'display' => 'color',
        'id' => 'idtbl_colors',
        'search' => '<div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Select color</div>
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Blue</div>
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Red</div>'
    ],
    [
        'label' => 'Shape',
        'var' => 'shapes',
        'name' => 'idtbl_shapes',
        'item' => 'shape',
        'display' => 'shape',
        'id' => 'idtbl_shapes',
        'search' => '<div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Select shape</div>
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Oval</div>'
    ],
    [
        'label' => 'Cutting type',
        'var' => 'cuts',
        'name' => 'idtbl_cuts',
        'item' => 'cut',
        'display' => 'cut',
        'id' => 'idtbl_cuts',
        'search' => '<div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Select cutting type</div>'
    ],
    [
        'label' => 'Treatment',
        'var' => 'treatments',
        'name' => 'idtbl_treatments',
        'item' => 'treatment',
        'display' => 'treatment',
        'id' => 'idtbl_treatments',
        'search' => '<div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Select treatment</div>'
    ],
    [
        'label' => 'Origin',
        'var' => 'origins',
        'name' => 'idtbl_origins',
        'item' => 'origin',
        'display' => 'origin',
        'id' => 'idtbl_origins',
        'search' => '<div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Select origin</div>'
    ],
    [
        'label' => 'Color grade',
        'var' => 'colorGrades',
        'name' => 'idtbl_color_grade',
        'item' => 'colorGrade',
        'display' => 'color_grade',
        'id' => 'idtbl_color_grade',
        'search' => '<div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Select color grade</div>'
    ],
    [
        'label' => 'Cut grade',
        'var' => 'cutGrades',
        'name' => 'idtbl_cuttinggrade',
        'item' => 'cutGrade',
        'display' => 'cuttinggrade',
        'id' => 'idtbl_cuttinggrade',
        'search' => '<div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Select cut grade</div>'
    ],
    [
        'label' => 'Clarity grade',
        'var' => 'clarityGrades',
        'name' => 'idtbl_clarity_grade',
        'item' => 'clarityGrade',
        'display' => 'clarity_grade',
        'id' => 'idtbl_clarity_grade',
        'search' => '<div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Select clarity grade</div>'
    ],
    [
        'label' => 'Storage locations',
        'var' => 'storageLocations',
        'name' => 'idtbl_storage_locations',
        'item' => 'storageLocation',
        'display' => 'storage_location',
        'id' => 'idtbl_storage_locations',
        'search' => '<div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Select storage location</div>'
    ],
    [
        'label' => 'Select tray / box#',
        'var' => 'trayBoxes',
        'name' => 'idtbl_tray_box',
        'item' => 'trayBox',
        'display' => 'tray_box',
        'id' => 'idtbl_tray_box',
        'search' => '<div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Select tray / box#</div>'
    ],
    [
        'label' => 'Supplier ref/name',
        'var' => 'suppliers',
        'name' => 'idtbl_suppliers',
        'item' => 'supplier',
        'display' => 'supplier_name',
        'id' => 'idtbl_suppliers',
        'search' => '<div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Select Supplier ref/name</div>'
    ],
    [
        'label' => 'Ownership Type',
        'var' => 'ownershipTypes',
        'name' => 'idtbl_ownership_type',
        'item' => 'ownershipType',
        'display' => 'ownership_type',
        'id' => 'idtbl_ownership_type',
        'search' => '<div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Select Ownership Type</div>'
    ],
    [
        'label' => 'Weight unit',
        'var' => 'weightUnits',
        'name' => 'idtbl_weight_units',
        'item' => 'weightUnit',
        'display' => 'unit_name',
        'id' => 'idtbl_weight_units',
        'search' => '<div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">ct</div>
                                <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">g</div>'
    ]
];

foreach ($replacements as $r) {
    $searchBlock = $r['search'];
    preg_match('/>([^<]+)<\/div>/', $searchBlock, $matches);
    $defaultText = $matches[1] ?? 'Select';
    
    $replaceBlock = '<div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">' . $defaultText . '</div>' . "\n";
    $replaceBlock .= '                        @foreach($' . $r['var'] . ' as $' . $r['item'] . ')' . "\n";
    
    if ($r['var'] === 'skus') {
        $displayExpr = '$' . $r['item'] . '->prefix ?? $' . $r['item'] . '->' . $r['id'];
    } else {
        $displayExpr = '$' . $r['item'] . '->' . $r['display'] . ' ?? $' . $r['item'] . '->name ?? $' . $r['item'] . '->' . $r['id'];
    }
    
    $replaceBlock .= '                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="{{ $' . $r['item'] . '->' . $r['id'] . ' }}">{{ ' . $displayExpr . ' }}</div>' . "\n";
    $replaceBlock .= '                        @endforeach';
    
    // Do the inner replacement first
    $content = str_replace($searchBlock, $replaceBlock, $content);
}

// Now we need to inject the hidden inputs. We can do this by regex matching each block
foreach ($replacements as $r) {
    $name = $r['name'];
    $var = $r['var'];
    
    // Find the wrapper block that contains the foreach for this var and inject the hidden input right after the wrapper div
    $pattern = '/(<div class="relative w-[^\"]*custom-select-wrapper">)\s*(<button type="button"[^>]*>\s*<span[^>]*>[^<]*<\/span>\s*<\/button>\s*<div[^>]*>.*?<\/div>\s*<div class="custom-dropdown-panel">\s*<div[^>]*>.*?<\/div>\s*@foreach\(\$' . preg_quote($var, '/') . ' as)/s';
    
    $content = preg_replace($pattern, '$1' . "\n" . '                    <input type="hidden" name="' . $name . '" value="">' . "\n" . '                    $2', $content);
}

// Ensure the category uses the real data too
$categoryHtml = '<div class="relative">
                    <input type="text" value="Gemstone" readonly class="form-control px-3 bg-slate-50/50 text-slate-500">';
$newCategoryHtml = '<div class="relative">
                    <input type="hidden" name="idtbl_product_types" value="{{ $productTypes->first()->idtbl_product_types ?? \'\' }}">
                    <input type="text" value="{{ $productTypes->first()->product_type ?? \'Gemstone\' }}" readonly class="form-control px-3 bg-slate-50/50 text-slate-500">';
$content = str_replace($categoryHtml, $newCategoryHtml, $content);

file_put_contents($file, $content);
echo "Done\n";
