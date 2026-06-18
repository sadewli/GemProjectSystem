import re

files = [
    r'c:\Users\Admin\OneDrive\Desktop\erav_gemsystem\resources\views\inventory\myinventory\fullpage\fullpage\partials\_overview.blade.php',
    r'c:\Users\Admin\OneDrive\Desktop\erav_gemsystem\resources\views\inventory\myinventory\fullpage\fullpage\partials\_advance.blade.php'
]

mapping = {
    'subCategories': 'tbl_sub_categories',
    'varieties': 'tbl_varieties',
    'colors': 'tbl_colors',
    'shapes': 'tbl_shapes',
    'cuts': 'tbl_cuts',
    'treatments': 'tbl_treatments',
    'origins': 'tbl_origins',
    'colorGrades': 'tbl_color_grade',
    'cutGrades': 'tbl_cuttinggrade',
    'clarityGrades': 'tbl_clarity_grade',
    'storageLocations': 'tbl_storage_locations',
    'trayBoxes': 'tbl_tray_box',
    'suppliers': 'tbl_suppliers',
    'ownershipTypes': 'tbl_ownership_type'
}

button_template = '''
                        <div class="border-t border-slate-100 mt-1 pt-1">
                            <button type="button" class="create-new-btn flex items-center gap-2 text-[13px] font-semibold text-[#2563eb] hover:text-blue-800 w-full px-3 py-2 transition-colors" data-table="{table}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Create New
                            </button>
                        </div>'''

for filepath in files:
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    for var, table in mapping.items():
        pattern = r'(@foreach\(\$' + var + r'(?: \?\? \[\])? as \$[^)]+\).*?@endforeach)'
        
        def rep(m):
            return m.group(1) + button_template.format(table=table)
            
        content = re.sub(pattern, rep, content, flags=re.DOTALL)

    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
