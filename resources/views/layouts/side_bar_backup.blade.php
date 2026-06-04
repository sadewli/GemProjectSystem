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

    // Active path checker helper logic
    $isDashboardActive = request()->is('Welcome/Dashboard*') || request()->is('/') || request()->is('Welcome');
    $isInventoryActive = request()->is('Inventory/*');
    $isSalesActive = request()->is('Distributor/*');
    $isCrmActive = request()->is('crm/*');
    $isProductionActive = request()->is('production/*');
    $isSystemUsersActive = request()->is('User/*');
    $isMasterDataActive = request()->is('Master/*');
@endphp
<textarea class="hidden" id="actiontext">{{ session('msg') }}</textarea>

<!-- Msway Logistic standard Sidebar HTML Layout -->
<div class="sidebar" id="sidebar">
    <!-- Desktop Navigation Layer -->
    <ul class="nav-list hidden sm:block">
        <!-- Dashboard -->
        <li class="{{ $isDashboardActive ? 'active' : '' }}">
            <a href="{{ url('Welcome/Dashboard') }}" id="dashboard_link" class="{{ $isDashboardActive ? 'active-link' : '' }}">
                <i class="fa-light fa-house"></i>
                <span class="links_name">Dashboard</span>
            </a>
            <span class="tooltip">Dashboard</span>
        </li>

        <!-- Inventory -->
        <li class="sidebar-item">
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapseInventory"
               aria-expanded="{{ $isInventoryActive ? 'true' : 'false' }}"
               class="{{ $isInventoryActive ? '' : 'collapsed' }}">
                <i class="fa-light fa-boxes"></i>
                <span class="links_name">Inventory <i class="collapse-icon"></i></span>
            </a>
            <span class="tooltip">Inventory</span>
            <div class="collapse {{ $isInventoryActive ? 'show' : '' }}" id="collapseInventory" data-parent="#sidebar">
                <nav class="sidenav-menu-nested nav accordion">
                    <a class="nav-link {{ request()->is('Inventory/MyInventory*') ? 'active' : '' }}" href="{{ url('Inventory/MyInventory') }}">My inventory</a>
                    <a class="nav-link {{ request()->is('Inventory/memoin*') ? 'active' : '' }}" href="{{ url('Inventory/memoin') }}">Memo in</a>
                    <a class="nav-link" href="javascript:void(0);">Memo out</a>
                    <a class="nav-link {{ request()->is('Inventory/archived*') ? 'active' : '' }}" href="{{ url('Inventory/archived') }}">Archived</a>
                    <a class="nav-link {{ request()->is('Inventory/inventorylist*') ? 'active' : '' }}" href="{{ url('Inventory/inventorylist') }}">Inventory list</a>
                    <a class="nav-link" href="javascript:void(0);">Stock take</a>
                    <a class="nav-link {{ request()->is('Inventory/inventoryadjustment*') ? 'active' : '' }}" href="{{ url('Inventory/inventoryadjustment') }}">Inventory adjustment</a>
                    <a class="nav-link {{ request()->is('Inventory/negativeinventory*') ? 'active' : '' }}" href="{{ url('Inventory/negativeinventory') }}">Negative inventory</a>
                    <a class="nav-link {{ request()->is('Inventory/productcode*') ? 'active' : '' }}" href="{{ url('Inventory/productcode') }}">Product code</a>
                </nav>
            </div>
        </li>

        <!-- Sales & Purchases -->
        <li class="sidebar-item">
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapseSales"
               aria-expanded="{{ $isSalesActive ? 'true' : 'false' }}"
               class="{{ $isSalesActive ? '' : 'collapsed' }}">
                <i class="fa-light fa-chart-column"></i>
                <span class="links_name">Sales & Purchases <i class="collapse-icon"></i></span>
            </a>
            <span class="tooltip">Sales & Purchases</span>
            <div class="collapse {{ $isSalesActive ? 'show' : '' }}" id="collapseSales" data-parent="#sidebar">
                <nav class="sidenav-menu-nested nav accordion">
                    <a class="nav-link" href="javascript:void(0);">Invoice</a>
                    <a class="nav-link" href="javascript:void(0);">Customer memo</a>
                    <a class="nav-link" href="javascript:void(0);">Quotation</a>
                    <a class="nav-link" href="javascript:void(0);">Shipping invoice</a>
                    <a class="nav-link" href="javascript:void(0);">Transfer documents</a>
                    <a class="nav-link" href="javascript:void(0);">Purchase order</a>
                    <a class="nav-link" href="javascript:void(0);">Supplier memo</a>
                    <a class="nav-link {{ request()->is('Distributor/GRN*') ? 'active' : '' }}" href="{{ url('Distributor/GRN') }}">Distributor GRN</a>
                </nav>
            </div>
        </li>

        <!-- CRM -->
        <li class="sidebar-item">
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapseCRM"
               aria-expanded="{{ $isCrmActive ? 'true' : 'false' }}"
               class="{{ $isCrmActive ? '' : 'collapsed' }}">
                <i class="fa-light fa-user-group"></i>
                <span class="links_name">CRM <i class="collapse-icon"></i></span>
            </a>
            <span class="tooltip">CRM</span>
            <div class="collapse {{ $isCrmActive ? 'show' : '' }}" id="collapseCRM" data-parent="#sidebar">
                <nav class="sidenav-menu-nested nav accordion">
                    <a class="nav-link {{ request()->is('crm/companies*') ? 'active' : '' }}" href="{{ url('crm/companies') }}">Companies</a>
                    <a class="nav-link {{ request()->is('crm/contacts*') ? 'active' : '' }}" href="{{ url('crm/contacts') }}">Contact</a>
                </nav>
            </div>
        </li>

        <!-- Production -->
        <li class="sidebar-item">
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapseProduction"
               aria-expanded="{{ $isProductionActive ? 'true' : 'false' }}"
               class="{{ $isProductionActive ? '' : 'collapsed' }}">
                <i class="fa-light fa-sitemap"></i>
                <span class="links_name">Production <i class="collapse-icon"></i></span>
            </a>
            <span class="tooltip">Production</span>
            <div class="collapse {{ $isProductionActive ? 'show' : '' }}" id="collapseProduction" data-parent="#sidebar">
                <nav class="sidenav-menu-nested nav accordion">
                    <a class="nav-link {{ request()->is('production/overview*') ? 'active' : '' }}" href="{{ url('production/overview') }}">Overview</a>
                    <a class="nav-link" href="javascript:void(0);">Re-cutting</a>
                    <a class="nav-link" href="javascript:void(0);">Cutting</a>
                    <a class="nav-link" href="javascript:void(0);">Re-assortment</a>
                    <a class="nav-link" href="javascript:void(0);">Treatment</a>
                    <a class="nav-link" href="javascript:void(0);">Product transfer</a>
                </nav>
            </div>
        </li>

        <!-- System Users -->
        @if(menucheck($menuprivilegearray, 2) == 1 || menucheck($menuprivilegearray, 3) == 1 || menucheck($menuprivilegearray, 4) == 1)
            <li class="sidebar-item">
                <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapseSystemUsers"
                   aria-expanded="{{ $isSystemUsersActive ? 'true' : 'false' }}"
                   class="{{ $isSystemUsersActive ? '' : 'collapsed' }}">
                    <i class="fa-light fa-users-cog"></i>
                    <span class="links_name">System Users <i class="collapse-icon"></i></span>
                </a>
                <span class="tooltip">System Users</span>
                <div class="collapse {{ $isSystemUsersActive ? 'show' : '' }}" id="collapseSystemUsers" data-parent="#sidebar">
                    <nav class="sidenav-menu-nested nav accordion">
                        @if(menucheck($menuprivilegearray, 2) == 1)
                            <a class="nav-link {{ request()->is('User/Useraccount*') ? 'active' : '' }}" href="{{ url('User/Useraccount') }}">User Account</a>
                        @endif
                        @if(menucheck($menuprivilegearray, 3) == 1)
                            <a class="nav-link {{ request()->is('User/Usertype*') ? 'active' : '' }}" href="{{ url('User/Usertype') }}">User Type</a>
                        @endif
                        @if(menucheck($menuprivilegearray, 4) == 1)
                            <a class="nav-link {{ request()->is('User/Userprivilege*') ? 'active' : '' }}" href="{{ url('User/Userprivilege') }}">User Privilege</a>
                        @endif
                    </nav>
                </div>
            </li>
        @endif

        <!-- Master Data -->
        <li class="sidebar-item">
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapseMasterData"
               aria-expanded="{{ $isMasterDataActive ? 'true' : 'false' }}"
               class="{{ $isMasterDataActive ? '' : 'collapsed' }}">
                <i class="fa-light fa-database"></i>
                <span class="links_name">Master Data <i class="collapse-icon"></i></span>
            </a>
            <span class="tooltip">Master Data</span>
            <div class="collapse {{ $isMasterDataActive ? 'show' : '' }}" id="collapseMasterData" data-parent="#sidebar">
                <nav class="sidenav-menu-nested nav accordion">
                    <a class="nav-link {{ request()->is('Master/Variety*') ? 'active' : '' }}" href="{{ url('Master/Variety') }}">Variety</a>
                    <a class="nav-link {{ request()->is('Master/Subcategory*') ? 'active' : '' }}" href="{{ url('Master/Subcategory') }}">Sub-Category</a>
                    <a class="nav-link {{ request()->is('Master/Color*') ? 'active' : '' }}" href="{{ url('Master/Color') }}">Color</a>
                    <a class="nav-link {{ request()->is('Master/ColorCategory*') ? 'active' : '' }}" href="{{ url('Master/ColorCategory') }}">Color Category</a>
                    <a class="nav-link {{ request()->is('Master/ShapeCut*') ? 'active' : '' }}" href="{{ url('Master/ShapeCut') }}">Shapes / Cutting</a>
                    <a class="nav-link {{ request()->is('Master/Grade*') ? 'active' : '' }}" href="{{ url('Master/Grade') }}">Grades</a>
                    <a class="nav-link {{ request()->is('Master/OriginTreatment*') ? 'active' : '' }}" href="{{ url('Master/OriginTreatment') }}">Origin & Treatment</a>
                    <a class="nav-link {{ request()->is('Master/StorageLocation*') ? 'active' : '' }}" href="{{ url('Master/StorageLocation') }}">Storage Locations</a>
                </nav>
            </div>
        </li>
    </ul>

    <!-- Mobile Navigation Layer (Accordion) -->
    <div class="accordion block sm:hidden" id="accordionSidenav">
        <ul class="nav-list">
            <!-- Dashboard -->
            <li class="{{ $isDashboardActive ? 'active' : '' }}">
                <a href="{{ url('Welcome/Dashboard') }}" class="{{ $isDashboardActive ? 'active-link' : '' }}">
                    <i class="fa-light fa-house"></i>
                    <span class="links_name">Dashboard</span>
                </a>
            </li>

            <!-- Inventory -->
            <li class="sidebar-item">
                <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapseInventoryMobile"
                   aria-expanded="{{ $isInventoryActive ? 'true' : 'false' }}"
                   class="{{ $isInventoryActive ? '' : 'collapsed' }}">
                    <i class="fa-light fa-boxes"></i>
                    <span class="links_name">Inventory <i class="collapse-icon"></i></span>
                </a>
                <div class="collapse {{ $isInventoryActive ? 'show' : '' }}" id="collapseInventoryMobile" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion">
                        <a class="nav-link {{ request()->is('Inventory/MyInventory*') ? 'active' : '' }}" href="{{ url('Inventory/MyInventory') }}">My inventory</a>
                        <a class="nav-link {{ request()->is('Inventory/memoin*') ? 'active' : '' }}" href="{{ url('Inventory/memoin') }}">Memo in</a>
                        <a class="nav-link" href="javascript:void(0);">Memo out</a>
                        <a class="nav-link {{ request()->is('Inventory/archived*') ? 'active' : '' }}" href="{{ url('Inventory/archived') }}">Archived</a>
                        <a class="nav-link {{ request()->is('Inventory/inventorylist*') ? 'active' : '' }}" href="{{ url('Inventory/inventorylist') }}">Inventory list</a>
                        <a class="nav-link" href="javascript:void(0);">Stock take</a>
                        <a class="nav-link {{ request()->is('Inventory/inventoryadjustment*') ? 'active' : '' }}" href="{{ url('Inventory/inventoryadjustment') }}">Inventory adjustment</a>
                        <a class="nav-link {{ request()->is('Inventory/negativeinventory*') ? 'active' : '' }}" href="{{ url('Inventory/negativeinventory') }}">Negative inventory</a>
                        <a class="nav-link {{ request()->is('Inventory/productcode*') ? 'active' : '' }}" href="{{ url('Inventory/productcode') }}">Product code</a>
                    </nav>
                </div>
            </li>

            <!-- Sales & Purchases -->
            <li class="sidebar-item">
                <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapseSalesMobile"
                   aria-expanded="{{ $isSalesActive ? 'true' : 'false' }}"
                   class="{{ $isSalesActive ? '' : 'collapsed' }}">
                    <i class="fa-light fa-chart-column"></i>
                    <span class="links_name">Sales & Purchases <i class="collapse-icon"></i></span>
                </a>
                <div class="collapse {{ $isSalesActive ? 'show' : '' }}" id="collapseSalesMobile" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion">
                        <a class="nav-link" href="javascript:void(0);">Invoice</a>
                        <a class="nav-link" href="javascript:void(0);">Customer memo</a>
                        <a class="nav-link" href="javascript:void(0);">Quotation</a>
                        <a class="nav-link" href="javascript:void(0);">Shipping invoice</a>
                        <a class="nav-link" href="javascript:void(0);">Transfer documents</a>
                        <a class="nav-link" href="javascript:void(0);">Purchase order</a>
                        <a class="nav-link" href="javascript:void(0);">Supplier memo</a>
                        <a class="nav-link {{ request()->is('Distributor/GRN*') ? 'active' : '' }}" href="{{ url('Distributor/GRN') }}">Distributor GRN</a>
                    </nav>
                </div>
            </li>

            <!-- CRM -->
            <li class="sidebar-item">
                <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapseCRMMobile"
                   aria-expanded="{{ $isCrmActive ? 'true' : 'false' }}"
                   class="{{ $isCrmActive ? '' : 'collapsed' }}">
                    <i class="fa-light fa-user-group"></i>
                    <span class="links_name">CRM <i class="collapse-icon"></i></span>
                </a>
                <div class="collapse {{ $isCrmActive ? 'show' : '' }}" id="collapseCRMMobile" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion">
                        <a class="nav-link {{ request()->is('crm/companies*') ? 'active' : '' }}" href="{{ url('crm/companies') }}">Companies</a>
                        <a class="nav-link {{ request()->is('crm/contacts*') ? 'active' : '' }}" href="{{ url('crm/contacts') }}">Contact</a>
                    </nav>
                </div>
            </li>

            <!-- Production -->
            <li class="sidebar-item">
                <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapseProductionMobile"
                   aria-expanded="{{ $isProductionActive ? 'true' : 'false' }}"
                   class="{{ $isProductionActive ? '' : 'collapsed' }}">
                    <i class="fa-light fa-sitemap"></i>
                    <span class="links_name">Production <i class="collapse-icon"></i></span>
                </a>
                <div class="collapse {{ $isProductionActive ? 'show' : '' }}" id="collapseProductionMobile" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion">
                        <a class="nav-link {{ request()->is('production/overview*') ? 'active' : '' }}" href="{{ url('production/overview') }}">Overview</a>
                        <a class="nav-link" href="javascript:void(0);">Re-cutting</a>
                        <a class="nav-link" href="javascript:void(0);">Cutting</a>
                        <a class="nav-link" href="javascript:void(0);">Re-assortment</a>
                        <a class="nav-link" href="javascript:void(0);">Treatment</a>
                        <a class="nav-link" href="javascript:void(0);">Product transfer</a>
                    </nav>
                </div>
            </li>

            <!-- System Users -->
            @if(menucheck($menuprivilegearray, 2) == 1 || menucheck($menuprivilegearray, 3) == 1 || menucheck($menuprivilegearray, 4) == 1)
                <li class="sidebar-item">
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapseSystemUsersMobile"
                       aria-expanded="{{ $isSystemUsersActive ? 'true' : 'false' }}"
                       class="{{ $isSystemUsersActive ? '' : 'collapsed' }}">
                        <i class="fa-light fa-users-cog"></i>
                        <span class="links_name">System Users <i class="collapse-icon"></i></span>
                    </a>
                    <div class="collapse {{ $isSystemUsersActive ? 'show' : '' }}" id="collapseSystemUsersMobile" data-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav accordion">
                            @if(menucheck($menuprivilegearray, 2) == 1)
                                <a class="nav-link {{ request()->is('User/Useraccount*') ? 'active' : '' }}" href="{{ url('User/Useraccount') }}">User Account</a>
                            @endif
                            @if(menucheck($menuprivilegearray, 3) == 1)
                                <a class="nav-link {{ request()->is('User/Usertype*') ? 'active' : '' }}" href="{{ url('User/Usertype') }}">User Type</a>
                            @endif
                            @if(menucheck($menuprivilegearray, 4) == 1)
                                <a class="nav-link {{ request()->is('User/Userprivilege*') ? 'active' : '' }}" href="{{ url('User/Userprivilege') }}">User Privilege</a>
                            @endif
                        </nav>
                    </div>
                </li>
            @endif

            <!-- Master Data -->
            <li class="sidebar-item">
                <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapseMasterDataMobile"
                   aria-expanded="{{ $isMasterDataActive ? 'true' : 'false' }}"
                   class="{{ $isMasterDataActive ? '' : 'collapsed' }}">
                    <i class="fa-light fa-database"></i>
                    <span class="links_name">Master Data <i class="collapse-icon"></i></span>
                </a>
                <div class="collapse {{ $isMasterDataActive ? 'show' : '' }}" id="collapseMasterDataMobile" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion">
                        <a class="nav-link {{ request()->is('Master/Variety*') ? 'active' : '' }}" href="{{ url('Master/Variety') }}">Variety</a>
                        <a class="nav-link {{ request()->is('Master/Subcategory*') ? 'active' : '' }}" href="{{ url('Master/Subcategory') }}">Sub-Category</a>
                        <a class="nav-link {{ request()->is('Master/Color*') ? 'active' : '' }}" href="{{ url('Master/Color') }}">Color</a>
                        <a class="nav-link {{ request()->is('Master/ColorCategory*') ? 'active' : '' }}" href="{{ url('Master/ColorCategory') }}">Color Category</a>
                        <a class="nav-link {{ request()->is('Master/ShapeCut*') ? 'active' : '' }}" href="{{ url('Master/ShapeCut') }}">Shapes / Cutting</a>
                        <a class="nav-link {{ request()->is('Master/Grade*') ? 'active' : '' }}" href="{{ url('Master/Grade') }}">Grades</a>
                        <a class="nav-link {{ request()->is('Master/OriginTreatment*') ? 'active' : '' }}" href="{{ url('Master/OriginTreatment') }}">Origin & Treatment</a>
                        <a class="nav-link {{ request()->is('Master/StorageLocation*') ? 'active' : '' }}" href="{{ url('Master/StorageLocation') }}">Storage Locations</a>
                    </nav>
                </div>
            </li>
        </ul>
    </div>
</div>
