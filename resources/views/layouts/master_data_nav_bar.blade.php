<div class="flex flex-wrap items-center gap-4 py-2.5 mb-2 relative z-50">
    <!-- Variety Master Dropdown -->
    <div class="dropdown group relative">
        <a class="text-sm font-bold text-gray-800 dropdown-toggle hover:text-gray-900 no-underline" href="#" role="button" id="varietyMasterDropdown">
            Variety Master
        </a>
        <div class="dropdown-menu shadow-sm border-0 mt-2 rounded-lg absolute hidden group-hover:block bg-white min-w-[150px] z-50" aria-labelledby="varietyMasterDropdown">
            <a class="dropdown-item text-sm font-bold py-1.5 px-4 hover:bg-gray-100 block" href="{{ url('Master/Variety') }}">Variety</a>
            <a class="dropdown-item text-sm font-bold py-1.5 px-4 hover:bg-gray-100 block" href="{{ url('Master/Subcategory') }}">Sub-Category</a>
        </div>
    </div>

    <!-- Color Master Dropdown -->
    <div class="dropdown group relative">
        <a class="text-sm font-bold text-gray-800 dropdown-toggle hover:text-gray-900 no-underline" href="#" role="button" id="colorMasterDropdown">
            Color Master
        </a>
        <div class="dropdown-menu shadow-sm border-0 mt-2 rounded-lg absolute hidden group-hover:block bg-white min-w-[150px] z-50" aria-labelledby="colorMasterDropdown">
            <a class="dropdown-item text-sm font-bold py-1.5 px-4 hover:bg-gray-100 block" href="{{ url('Master/Color') }}">Color</a>
            <a class="dropdown-item text-sm font-bold py-1.5 px-4 hover:bg-gray-100 block" href="{{ url('Master/ColorCategory') }}">Color Category</a>
        </div>
    </div>

    <!-- Product Master Dropdown -->
    <div class="dropdown group relative">
        <a class="text-sm font-bold text-gray-800 dropdown-toggle hover:text-gray-900 no-underline" href="#" role="button" id="productMasterDropdown">
            Product Master
        </a>
        <div class="dropdown-menu shadow-sm border-0 mt-2 rounded-lg absolute hidden group-hover:block bg-white min-w-[200px] z-50" aria-labelledby="productMasterDropdown">
            <a class="dropdown-item text-sm font-bold py-1.5 px-4 hover:bg-gray-100 block" href="{{ url('Master/ShapeCut') }}">Shapes / Cutting</a>
            <a class="dropdown-item text-sm font-bold py-1.5 px-4 hover:bg-gray-100 block" href="{{ url('Master/Grade') }}">Grades</a>
            <a class="dropdown-item text-sm font-bold py-1.5 px-4 hover:bg-gray-100 block" href="{{ url('Master/OriginTreatment') }}">Origin & Treatment</a>
        </div>
    </div>

    <!-- Location Master -->
    <a class="text-sm font-bold text-gray-800 hover:text-gray-900 no-underline" href="{{ url('Master/StorageLocation') }}">Storage Locations</a>
</div>
