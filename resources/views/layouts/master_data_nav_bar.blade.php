<ul class="nav nav-pills mb-3 bg-light p-2 rounded shadow-sm" id="masterDataNavBar" style="gap: 0.5rem;">
    <!-- Variety Master Dropdown -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle font-weight-bold text-dark" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Variety Master</a>
        <div class="dropdown-menu shadow-sm border-0 mt-1">
            <a class="dropdown-item font-weight-bold text-sm" href="{{ url('Master/Variety') }}">Variety</a>
            <a class="dropdown-item font-weight-bold text-sm" href="{{ url('Master/Subcategory') }}">Sub-Category</a>
        </div>
    </li>

    <!-- Color Master Dropdown -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle font-weight-bold text-dark" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Color Master</a>
        <div class="dropdown-menu shadow-sm border-0 mt-1">
            <a class="dropdown-item font-weight-bold text-sm" href="{{ url('Master/Color') }}">Color</a>
            <a class="dropdown-item font-weight-bold text-sm" href="{{ url('Master/ColorGrade') }}">Color Grade</a>
        </div>
    </li>

    <!-- Product Master Dropdown -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle font-weight-bold text-dark" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Product Master</a>
        <div class="dropdown-menu shadow-sm border-0 mt-1">
            <a class="dropdown-item font-weight-bold text-sm" href="{{ url('Master/ProductType') }}">Product Type</a>
            <a class="dropdown-item font-weight-bold text-sm" href="{{ url('Master/Shape') }}">Shapes</a>
            <a class="dropdown-item font-weight-bold text-sm" href="{{ url('Master/Cut') }}">Cuts</a>
            <a class="dropdown-item font-weight-bold text-sm" href="{{ url('Master/CuttingGrade') }}">Cutting Grades</a>
            <a class="dropdown-item font-weight-bold text-sm" href="{{ url('Master/ClarityGrade') }}">Clarity Grades</a>
            <a class="dropdown-item font-weight-bold text-sm" href="{{ url('Master/GradeType') }}">Grade Types</a>
            <a class="dropdown-item font-weight-bold text-sm" href="{{ url('Master/Grade') }}">Grades</a>
            <a class="dropdown-item font-weight-bold text-sm" href="{{ url('Master/Origin') }}">Origins</a>
            <a class="dropdown-item font-weight-bold text-sm" href="{{ url('Master/Treatment') }}">Treatments</a>
            <a class="dropdown-item font-weight-bold text-sm" href="{{ url('Master/Sku') }}">SKU</a>
        </div>
    </li>

    <!-- Location Master -->
    <li class="nav-item">
        <a class="nav-link font-weight-bold text-dark" href="{{ url('Master/StorageLocation') }}">Storage Locations</a>
    </li>

    <!-- Tray / Box Master -->
    <li class="nav-item">
        <a class="nav-link font-weight-bold text-dark" href="{{ url('Master/TrayBox') }}">Tray / Box</a>
    </li>

    <!-- Suppliers -->
    <li class="nav-item">
        <a class="nav-link font-weight-bold text-dark" href="{{ url('Master/Suppliers') }}">Suppliers</a>
    </li>

    <!-- Company Types Master -->
    <li class="nav-item">
        <a class="nav-link font-weight-bold text-dark" href="{{ url('Master/CompanyType') }}">Company Types</a>
    </li>

    <!-- Roles Master -->
    <li class="nav-item">
        <a class="nav-link font-weight-bold text-dark" href="{{ url('Master/Role') }}">Roles</a>
    </li>

    <!-- States Master -->
    <li class="nav-item">
        <a class="nav-link font-weight-bold text-dark" href="{{ url('Master/State') }}">States</a>
    </li>

    <!-- Countries Master -->
    <li class="nav-item">
        <a class="nav-link font-weight-bold text-dark" href="{{ url('Master/Country') }}">Countries</a>
    </li>
</ul>