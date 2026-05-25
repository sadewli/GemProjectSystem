@php
    $functionmenu = trim(request()->path(), '/');
    $functionmenu2 = last(explode('/', $functionmenu));
    $menuprivilegearray = $menuaccess ?? [];

    if (!function_exists('menucheck')) {
        function menucheck($arraymenu, $menuID)
        {
            foreach ($arraymenu as $array) {
                if ($array->menuid == $menuID && $array->access_status == 1)
                    return 1;
            }
            return 0;
        }
    }

    if (!function_exists('checkprivilege')) {
        function checkprivilege($arraymenu, $menuID, $type)
        {
            foreach ($arraymenu as $array) {
                if ($array->menuid == $menuID) {
                    if ($type == 1)
                        return $array->add;
                    if ($type == 2)
                        return $array->edit;
                    if ($type == 3)
                        return $array->statuschange;
                    if ($type == 4)
                        return $array->remove;
                }
            }
            return 0;
        }
    }

    $addcheck = $editcheck = $statuscheck = $deletecheck = 0;
    $menuMaps = ['Useraccount' => 2, 'Usertype' => 3, 'Userprivilege' => 4];

    if (array_key_exists($functionmenu2, $menuMaps)) {
        $id = $menuMaps[$functionmenu2];
        $addcheck = checkprivilege($menuprivilegearray, $id, 1);
        $editcheck = checkprivilege($menuprivilegearray, $id, 2);
        $statuscheck = checkprivilege($menuprivilegearray, $id, 3);
        $deletecheck = checkprivilege($menuprivilegearray, $id, 4);
    }
@endphp
<textarea class="hidden" id="actiontext">{{ session('msg') }}</textarea>

<!-- Msway Logistic standard Sidebar HTML Layout -->
<div class="sidebar" id="sidebar">
    <ul class="nav-list hidden sm:block">
        <li>
            <a href="{{ url('Welcome/Dashboard') }}" id="dashboard_link">
                <i class="fa-light fa-desktop"></i>
                <span class="links_name">Dashboard</span>
            </a>
            <span class="tooltip">Dashboard</span>
        </li>

        @if(menucheck($menuprivilegearray, 2) == 1 || menucheck($menuprivilegearray, 3) == 1 || menucheck($menuprivilegearray, 4) == 1)
            <li>
                <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapeSystemUsers" aria-expanded="false"
                    aria-controls="collapeSystemUsers">
                    <i class="fa-light fa-users-cog"></i>
                    <span class="links_name">System Users <i class="fas fa-angle-down"></i></span>
                </a>
                <span class="tooltip">System Users</span>
                <div class="collapse" id="collapeSystemUsers" data-parent="#sidebar">
                    <nav class="sidenav-menu-nested nav accordion">
                        @if(menucheck($menuprivilegearray, 2) == 1)
                            <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('User/Useraccount') }}">User
                                Account</a>
                        @endif
                        @if(menucheck($menuprivilegearray, 3) == 1)
                            <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('User/Usertype') }}">User Type</a>
                        @endif
                        @if(menucheck($menuprivilegearray, 4) == 1)
                            <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('User/Userprivilege') }}">User
                                Privilege</a>
                        @endif
                    </nav>
                </div>
            </li>
        @endif

        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapeMasterData" aria-expanded="false"
                aria-controls="collapeMasterData">
                <i class="fa-light fa-database"></i>
                <span class="links_name">Master Data <i class="fas fa-angle-down"></i></span>
            </a>
            <span class="tooltip">Master Data</span>
            <div class="collapse" id="collapeMasterData" data-parent="#sidebar">
                <nav class="sidenav-menu-nested nav accordion">
                    <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 font-bold mt-2"
                        href="javascript:void(0);">Variety Master</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('Master/Variety') }}">Variety</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                        href="{{ url('Master/Subcategory') }}">Sub-Category</a>

                    <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 font-bold mt-2"
                        href="javascript:void(0);">Color Master</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('Master/Color') }}">Color</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('Master/ColorCategory') }}">Color
                        Category</a>

                    <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 font-bold mt-2"
                        href="javascript:void(0);">Product Master</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('Master/ShapeCut') }}">Shapes /
                        Cutting</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('Master/Grade') }}">Grades</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('Master/OriginTreatment') }}">Origin
                        & Treatment</a>

                    <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 font-bold mt-2 hover:text-gray-900"
                        href="{{ url('Master/StorageLocation') }}">Storage Locations</a>
                </nav>
            </div>
        </li>

        <li class="sidebar-item">
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapseInventory" aria-expanded="false"
                aria-controls="collapseInventory">
                <i class="fa-light fa-boxes"></i>
                <span class="links_name">Inventory <i class="fas fa-angle-down"></i></span>
            </a>
            <span class="tooltip">Inventory</span>
            <div class="collapse" id="collapseInventory" data-parent="#sidebar">
                <nav class="sidenav-menu-nested nav accordion">
                    <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('Inventory/MyInventory') }}">My Inventory</a>
                    <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('Inventory/productcode') }}">Product Code</a>
                    <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('Inventory/negativeinventory') }}">Negative Inventory</a>
                    <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('Inventory/archived') }}">Archived</a>
                    <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('Inventory/memoin') }}">Memo In</a>
                    <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('Inventory/inventorylist') }}">Inventory List</a>
                    <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('Inventory/inventoryadjustment') }}">Inventory Adjustment</a>
                </nav>
            </div>
        </li>

        <li>
            <a href="{{ url('Distributor/GRN') }}">
                <i class="fa-light fa-box"></i>
                <span class="links_name">Distributor GRN</span>
            </a>
            <span class="tooltip">Distributor GRN</span>
        </li>
    </ul>

    <!-- Mobile Navigation Layer (Duplicate block for accordion) -->
    <div class="accordion block sm:hidden" id="accordionSidenav">
        <ul class="nav-list">
            <li>
                <a href="{{ url('Welcome/Dashboard') }}">
                    <i class="fa-light fa-desktop"></i>
                    <span class="links_name">Dashboard</span>
                </a>
            </li>

            @if(menucheck($menuprivilegearray, 2) == 1 || menucheck($menuprivilegearray, 3) == 1 || menucheck($menuprivilegearray, 4) == 1)
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapeSystemUsersMobile"
                        aria-expanded="false" aria-controls="collapeSystemUsersMobile">
                        <i class="fa-light fa-users-cog"></i>
                        <span class="links_name">System Users <i class="fas fa-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapeSystemUsersMobile" data-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav accordion">
                            @if(menucheck($menuprivilegearray, 2) == 1)
                                <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('User/Useraccount') }}">User
                                    Account</a>
                            @endif
                            @if(menucheck($menuprivilegearray, 3) == 1)
                                <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('User/Usertype') }}">User
                                    Type</a>
                            @endif
                            @if(menucheck($menuprivilegearray, 4) == 1)
                                <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('User/Userprivilege') }}">User
                                    Privilege</a>
                            @endif
                        </nav>
                    </div>
                </li>
            @endif

            <li>
                <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapeMasterDataMobile"
                    aria-expanded="false" aria-controls="collapeMasterDataMobile">
                    <i class="fa-light fa-database"></i>
                    <span class="links_name">Master Data <i class="fas fa-angle-down"></i></span>
                </a>
                <div class="collapse" id="collapeMasterDataMobile" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion">
                        <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 font-bold mt-2"
                            href="javascript:void(0);">Variety Master</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('Master/Variety') }}">Variety</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                            href="{{ url('Master/Subcategory') }}">Sub-Category</a>

                        <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 font-bold mt-2"
                            href="javascript:void(0);">Color Master</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('Master/Color') }}">Color</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('Master/ColorCategory') }}">Color
                            Category</a>

                        <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 font-bold mt-2"
                            href="javascript:void(0);">Product Master</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('Master/ShapeCut') }}">Shapes /
                            Cutting</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('Master/Grade') }}">Grades</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                            href="{{ url('Master/OriginTreatment') }}">Origin & Treatment</a>

                        <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 font-bold mt-2 hover:text-gray-900"
                            href="{{ url('Master/StorageLocation') }}">Storage Locations</a>
                    </nav>
                </div>
            </li>

            <li>
                <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapseInventoryMobile"
                    aria-expanded="false" aria-controls="collapseInventoryMobile">
                    <i class="fa-light fa-boxes"></i>
                    <span class="links_name">Inventory <i class="fas fa-angle-down"></i></span>
                </a>
                <div class="collapse" id="collapseInventoryMobile" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion">
                        <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('Inventory/MyInventory') }}">My Inventory</a>
                        <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('Inventory/productcode') }}">Product Code</a>
                        <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('Inventory/negativeinventory') }}">Negative Inventory</a>
                        <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('Inventory/archived') }}">Archived</a>
                        <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('Inventory/memoin') }}">Memo In</a>
                        <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('Inventory/inventorylist') }}">Inventory List</a>
                        <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 hover:text-gray-900" href="{{ url('Inventory/inventoryadjustment') }}">Inventory Adjustment</a>
                    </nav>
                </div>
            </li>

            <li>
                <a href="{{ url('Distributor/GRN') }}">
                    <i class="fa-light fa-box"></i>
                    <span class="links_name">Distributor GRN</span>
                </a>
            </li>
        </ul>
    </div>
</div>