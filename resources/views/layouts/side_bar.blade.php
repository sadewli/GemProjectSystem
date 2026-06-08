@php


    $functionmenu = trim(request()->path(), '/');
    $functionmenu2 = last(explode('/', $functionmenu));
    $menuprivilegearray = $menuaccess ?? [];

    $actionJSON = '';
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 4) {
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-save';
            $actionObj->title = '';
            $actionObj->message = 'Record Added Successfully';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'success';

            $actionJSON = json_encode($actionObj);
        } else if ($_GET['action'] == 1) {
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-check-circle';
            $actionObj->title = '';
            $actionObj->message = 'Record Activate Successfully';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'success';

            $actionJSON = json_encode($actionObj);
        } else if ($_GET['action'] == 2) {
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-times-circle';
            $actionObj->title = '';
            $actionObj->message = 'Record Deactivate Successfully';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'warning';

            $actionJSON = json_encode($actionObj);
        } else if ($_GET['action'] == 3) {
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-trash-alt';
            $actionObj->title = '';
            $actionObj->message = 'Record Delete Successfully';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'danger';

            $actionJSON = json_encode($actionObj);
        } else if ($_GET['action'] == 5) {
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-exclamation-triangle';
            $actionObj->title = '';
            $actionObj->message = 'Record Error';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'danger';

            $actionJSON = json_encode($actionObj);
        } else if ($_GET['action'] == 6) {
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-save';
            $actionObj->title = '';
            $actionObj->message = 'Record Update Successfully';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'primary';

            $actionJSON = json_encode($actionObj);
        } else if ($_GET['action'] == 7) {
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-exclamation-triangle';
            $actionObj->title = 'Missing Serials';
            $actionObj->message = 'Please add all required Serial Numbers before transferring to stock.';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'danger';

            $actionJSON = json_encode($actionObj);
        }
    }

    if (isset($_GET['error'])) {
        if ($_GET['error'] == 'wrong') {
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-times-circle';
            $actionObj->title = 'Login Failed';
            $actionObj->message = 'Invalid Username or Password';
            $actionObj->url = '';
            $actionObj->target = '_self';
            $actionObj->type = 'danger';

            $actionJSON = json_encode($actionObj);
        }
    }

    // Share the variable with all views
    \Illuminate\Support\Facades\View::share('actionJSON', $actionJSON);
@endphp

@if($actionJSON != '')
    <script>
        window.actionJSONData = {!! $actionJSON !!};
    </script>
@endif

@php
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
            <a href="{{ url('Welcome/Dashboard') }}" id="dashboard_link"
                class="{{ $isDashboardActive ? 'active-link' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span class="links_name">Dashboard</span>
            </a>
            <span class="tooltip">Dashboard</span>
        </li>

        <!-- Inventory -->
        <li class="sidebar-item">
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapseInventory"
                aria-expanded="{{ $isInventoryActive ? 'true' : 'false' }}"
                class="{{ $isInventoryActive ? '' : 'collapsed' }}">
                <i class="fas fa-boxes"></i>
                <span class="links_name">Inventory <span class="collapse-icon"></span>
            </a>
            <span class="tooltip">Inventory</span>
            <div class="collapse {{ $isInventoryActive ? 'show' : '' }}" id="collapseInventory" data-parent="#sidebar">
                <nav class="sidenav-menu-nested nav accordion">
                    <a class="nav-link {{ request()->is('Inventory/MyInventory*') ? 'active' : '' }}"
                        href="{{ url('Inventory/MyInventory') }}">My inventory</a>
                    <a class="nav-link {{ request()->is('Inventory/memoin*') ? 'active' : '' }}"
                        href="{{ url('Inventory/memoin') }}">Memo in</a>
                    <a class="nav-link {{ request()->is('Inventory/memoout*') ? 'active' : '' }}"
                        href="{{ url('Inventory/memoout') }}">Memo out</a>
                    <a class="nav-link {{ request()->is('Inventory/archived*') ? 'active' : '' }}"
                        href="{{ url('Inventory/archived') }}">Archived</a>
                    <a class="nav-link {{ request()->is('Inventory/inventorylist*') ? 'active' : '' }}"
                        href="{{ url('Inventory/inventorylist') }}">Inventory list</a>
                    <a class="nav-link" href="javascript:void(0);">Stock take</a>
                    <a class="nav-link {{ request()->is('Inventory/inventoryadjustment*') ? 'active' : '' }}"
                        href="{{ url('Inventory/inventoryadjustment') }}">Inventory adjustment</a>
                    <a class="nav-link {{ request()->is('Inventory/negativeinventory*') ? 'active' : '' }}"
                        href="{{ url('Inventory/negativeinventory') }}">Negative inventory</a>
                    <a class="nav-link {{ request()->is('Inventory/productcode*') ? 'active' : '' }}"
                        href="{{ url('Inventory/productcode') }}">Product code</a>
                </nav>
            </div>
        </li>

        <!-- Sales & Purchases -->
        <li class="sidebar-item">
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapseSales"
                aria-expanded="{{ $isSalesActive ? 'true' : 'false' }}" class="{{ $isSalesActive ? '' : 'collapsed' }}">
                <i class="fas fa-chart-bar"></i>
                <span class="links_name">Sales & Purchases <span class="collapse-icon"></span></span>
            </a>
            <span class="tooltip">Sales & Purchases</span>
            <div class="collapse {{ $isSalesActive ? 'show' : '' }}" id="collapseSales" data-parent="#sidebar">
                <nav class="sidenav-menu-nested nav accordion">
                    <a class="nav-link {{ request()->is('sales/invoice*') ? 'active' : '' }}" href="{{ url('sales/invoice') }}">Invoice</a>
                    <a class="nav-link {{ request()->is('sales/customer_memo*') ? 'active' : '' }}" href="{{ url('sales/customer_memo') }}">Customer Memo</a>
                    <a class="nav-link {{ request()->is('sales/quotation*') ? 'active' : '' }}" href="{{ url('sales/quotation') }}">Quotation</a>
                    <a class="nav-link {{ request()->is('sales/shipping_invoice*') ? 'active' : '' }}" href="{{ url('sales/shipping_invoice') }}">Shipping Invoice</a>
                    <a class="nav-link {{ request()->is('sales/location_transfer*') ? 'active' : '' }}" href="{{ url('sales/location_transfer') }}">Transfer Documents</a>
                    <a class="nav-link {{ request()->is('sales/purchase_order*') ? 'active' : '' }}" href="{{ url('sales/purchase_order') }}">Purchase Order</a>
                    <a class="nav-link {{ request()->is('sales/supplier_memo*') ? 'active' : '' }}" href="{{ url('sales/supplier_memo') }}">Supplier Memo</a>
                    <a class="nav-link {{ request()->is('Distributor/GRN*') ? 'active' : '' }}"
                        href="{{ url('Distributor/GRN') }}">Distributor GRN</a>
                </nav>
            </div>
        </li>

        <!-- CRM -->
        <li class="sidebar-item">
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapseCRM"
                aria-expanded="{{ $isCrmActive ? 'true' : 'false' }}" class="{{ $isCrmActive ? '' : 'collapsed' }}">
                <i class="fas fa-users"></i>
                <span class="links_name">CRM <span class="collapse-icon"></span>
            </a>
            <span class="tooltip">CRM</span>
            <div class="collapse {{ $isCrmActive ? 'show' : '' }}" id="collapseCRM" data-parent="#sidebar">
                <nav class="sidenav-menu-nested nav accordion">
                    <a class="nav-link {{ request()->is('crm/companies*') ? 'active' : '' }}"
                        href="{{ url('crm/companies') }}">Companies</a>
                    <a class="nav-link {{ request()->is('crm/contacts*') ? 'active' : '' }}"
                        href="{{ url('crm/contacts') }}">Contact</a>
                </nav>
            </div>
        </li>

        <!-- Production -->
        <li class="sidebar-item">
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapseProduction"
                aria-expanded="{{ $isProductionActive ? 'true' : 'false' }}"
                class="{{ $isProductionActive ? '' : 'collapsed' }}">
                <i class="fas fa-industry"></i>
                <span class="links_name">Production <span class="collapse-icon"></span>
            </a>
            <span class="tooltip">Production</span>
            <div class="collapse {{ $isProductionActive ? 'show' : '' }}" id="collapseProduction"
                data-parent="#sidebar">
                <nav class="sidenav-menu-nested nav accordion">
                    <a class="nav-link {{ request()->is('production/overview*') ? 'active' : '' }}"
                        href="{{ url('production/overview') }}">Overview</a>
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
                    <i class="fas fa-user-cog"></i>
                    <span class="links_name">System Users <span class="collapse-icon"></span>
                </a>
                <span class="tooltip">System Users</span>
                <div class="collapse {{ $isSystemUsersActive ? 'show' : '' }}" id="collapseSystemUsers"
                    data-parent="#sidebar">
                    <nav class="sidenav-menu-nested nav accordion">
                        @if(menucheck($menuprivilegearray, 2) == 1)
                            <a class="nav-link {{ request()->is('User/Useraccount*') ? 'active' : '' }}"
                                href="{{ url('User/Useraccount') }}">User Account</a>
                        @endif
                        @if(menucheck($menuprivilegearray, 3) == 1)
                            <a class="nav-link {{ request()->is('User/Usertype*') ? 'active' : '' }}"
                                href="{{ url('User/Usertype') }}">User Type</a>
                        @endif
                        @if(menucheck($menuprivilegearray, 4) == 1)
                            <a class="nav-link {{ request()->is('User/Userprivilege*') ? 'active' : '' }}"
                                href="{{ url('User/Userprivilege') }}">User Privilege</a>
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
                <i class="fas fa-database"></i>
                <span class="links_name">Master Data <span class="collapse-icon"></span>
            </a>
            <span class="tooltip">Master Data</span>
            <div class="collapse {{ $isMasterDataActive ? 'show' : '' }}" id="collapseMasterData"
                data-parent="#sidebar">
                <nav class="sidenav-menu-nested nav accordion">
                    <!-- Variety Master -->
                    <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 font-bold mt-2"
                        href="javascript:void(0);">Variety Master</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                        href="{{ url('Master/Variety') }}">Variety</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                        href="{{ url('Master/Subcategory') }}">Sub-Category</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                        href="{{ url('Master/ProductType') }}">Product Type</a>

                    <!-- Color Master -->
                    <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 font-bold mt-2"
                        href="javascript:void(0);">Color Master</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                        href="{{ url('Master/Color') }}">Color</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                        href="{{ url('Master/ColorCategory') }}">Color Category</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                        href="{{ url('Master/ColorGrade') }}">Color Grade</a>

                    <!-- Product Master -->
                    <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 font-bold mt-2"
                        href="javascript:void(0);">Product Master</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                        href="{{ url('Master/Shape') }}">Shape</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                        href="{{ url('Master/Cut') }}">Cut</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                        href="{{ url('Master/Grade') }}">Grade</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                        href="{{ url('Master/GradeType') }}">Grade Type</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                        href="{{ url('Master/CuttingGrade') }}">Cutting Grade</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                        href="{{ url('Master/ClarityGrade') }}">Clarity Grade</a>

                    <!-- Origin & Treatment -->
                    <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 font-bold mt-2"
                        href="javascript:void(0);">Origin & Treatment</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                        href="{{ url('Master/Origin') }}">Origin</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                        href="{{ url('Master/Treatment') }}">Treatment</a>

                    <!-- Storage & Location -->
                    <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 font-bold mt-2"
                        href="javascript:void(0);">Storage & Location</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                        href="{{ url('Master/StorageLocation') }}">Storage Location</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                        href="{{ url('Master/TrayBox') }}">Tray/Box</a>

                    <!-- Inventory -->
                    <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 font-bold mt-2"
                        href="javascript:void(0);">Inventory</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                        href="{{ url('Master/SKU') }}">SKU</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                        href="{{ url('Master/Supplier') }}">Supplier</a>

                    <!-- Company & Organization -->
                    <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 font-bold mt-2"
                        href="javascript:void(0);">Company & Organization</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                        href="{{ url('Master/CompanyType') }}">Company Type</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                        href="{{ url('Master/Country') }}">Country</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                        href="{{ url('Master/State') }}">State</a>
                    <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                        href="{{ url('Master/Role') }}">Role</a>
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
                    <i class="fas fa-gauge-high"></i>
                    <span class="links_name">Dashboard</span>
                </a>
            </li>

            <!-- Inventory -->
            <li class="sidebar-item">
                <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapseInventoryMobile"
                    aria-expanded="{{ $isInventoryActive ? 'true' : 'false' }}"
                    class="{{ $isInventoryActive ? '' : 'collapsed' }}">
                    <i class="fas fa-boxes-stacked"></i>
                    <span class="links_name">Inventory <span class="collapse-icon"></span>
                </a>
                <div class="collapse {{ $isInventoryActive ? 'show' : '' }}" id="collapseInventoryMobile"
                    data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion">
                        <a class="nav-link {{ request()->is('Inventory/MyInventory*') ? 'active' : '' }}"
                            href="{{ url('Inventory/MyInventory') }}">My inventory</a>
                        <a class="nav-link {{ request()->is('Inventory/memoin*') ? 'active' : '' }}"
                            href="{{ url('Inventory/memoin') }}">Memo in</a>
                        <a class="nav-link {{ request()->is('Inventory/memoout*') ? 'active' : '' }}"
                            href="{{ url('Inventory/memoout') }}">Memo out</a>
                        <a class="nav-link {{ request()->is('Inventory/archived*') ? 'active' : '' }}"
                            href="{{ url('Inventory/archived') }}">Archived</a>
                        <a class="nav-link {{ request()->is('Inventory/inventorylist*') ? 'active' : '' }}"
                            href="{{ url('Inventory/inventorylist') }}">Inventory list</a>
                        <a class="nav-link" href="javascript:void(0);">Stock take</a>
                        <a class="nav-link {{ request()->is('Inventory/inventoryadjustment*') ? 'active' : '' }}"
                            href="{{ url('Inventory/inventoryadjustment') }}">Inventory adjustment</a>
                        <a class="nav-link {{ request()->is('Inventory/negativeinventory*') ? 'active' : '' }}"
                            href="{{ url('Inventory/negativeinventory') }}">Negative inventory</a>
                        <a class="nav-link {{ request()->is('Inventory/productcode*') ? 'active' : '' }}"
                            href="{{ url('Inventory/productcode') }}">Product code</a>
                    </nav>
                </div>
            </li>

            <!-- Sales & Purchases -->
            <li class="sidebar-item">
                <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapseSalesMobile"
                    aria-expanded="{{ $isSalesActive ? 'true' : 'false' }}"
                    class="{{ $isSalesActive ? '' : 'collapsed' }}">
                    <i class="fas fa-chart-column"></i>
                    <span class="links_name">Sales & Purchases <span class="collapse-icon"></span></span>
                </a>
                <div class="collapse {{ $isSalesActive ? 'show' : '' }}" id="collapseSalesMobile"
                    data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion">
                        <a class="nav-link {{ request()->is('sales/invoice*') ? 'active' : '' }}" href="{{ url('sales/invoice') }}">Invoice</a>
                        <a class="nav-link {{ request()->is('sales/customer_memo*') ? 'active' : '' }}" href="{{ url('sales/customer_memo') }}">Customer Memo</a>
                        <a class="nav-link {{ request()->is('sales/quotation*') ? 'active' : '' }}" href="{{ url('sales/quotation') }}">Quotation</a>
                        <a class="nav-link {{ request()->is('sales/shipping_invoice*') ? 'active' : '' }}" href="{{ url('sales/shipping_invoice') }}">Shipping Invoice</a>
                        <a class="nav-link {{ request()->is('sales/location_transfer*') ? 'active' : '' }}" href="{{ url('sales/location_transfer') }}">Transfer Documents</a>
                        <a class="nav-link {{ request()->is('sales/purchase_order*') ? 'active' : '' }}" href="{{ url('sales/purchase_order') }}">Purchase Order</a>
                        <a class="nav-link {{ request()->is('sales/supplier_memo*') ? 'active' : '' }}" href="{{ url('sales/supplier_memo') }}">Supplier Memo</a>
                    </nav>
                </div>
            </li>

            <!-- CRM -->
            <li class="sidebar-item">
                <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapseCRMMobile"
                    aria-expanded="{{ $isCrmActive ? 'true' : 'false' }}" class="{{ $isCrmActive ? '' : 'collapsed' }}">
                    <i class="fas fa-users"></i>
                    <span class="links_name">CRM <span class="collapse-icon"></span>
                </a>
                <div class="collapse {{ $isCrmActive ? 'show' : '' }}" id="collapseCRMMobile"
                    data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion">
                        <a class="nav-link {{ request()->is('crm/companies*') ? 'active' : '' }}"
                            href="{{ url('crm/companies') }}">Companies</a>
                        <a class="nav-link {{ request()->is('crm/contacts*') ? 'active' : '' }}"
                            href="{{ url('crm/contacts') }}">Contact</a>
                    </nav>
                </div>
            </li>

            <!-- Production -->
            <li class="sidebar-item">
                <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapseProductionMobile"
                    aria-expanded="{{ $isProductionActive ? 'true' : 'false' }}"
                    class="{{ $isProductionActive ? '' : 'collapsed' }}">
                    <i class="fas fa-industry"></i>
                    <span class="links_name">Production <span class="collapse-icon"></span>
                </a>
                <div class="collapse {{ $isProductionActive ? 'show' : '' }}" id="collapseProductionMobile"
                    data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion">
                        <a class="nav-link {{ request()->is('production/overview*') ? 'active' : '' }}"
                            href="{{ url('production/overview') }}">Overview</a>
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
                        <i class="fas fa-user-gear"></i>
                        <span class="links_name">System Users <span class="collapse-icon"></span>
                    </a>
                    <div class="collapse {{ $isSystemUsersActive ? 'show' : '' }}" id="collapseSystemUsersMobile"
                        data-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav accordion">
                            @if(menucheck($menuprivilegearray, 2) == 1)
                                <a class="nav-link {{ request()->is('User/Useraccount*') ? 'active' : '' }}"
                                    href="{{ url('User/Useraccount') }}">User Account</a>
                            @endif
                            @if(menucheck($menuprivilegearray, 3) == 1)
                                <a class="nav-link {{ request()->is('User/Usertype*') ? 'active' : '' }}"
                                    href="{{ url('User/Usertype') }}">User Type</a>
                            @endif
                            @if(menucheck($menuprivilegearray, 4) == 1)
                                <a class="nav-link {{ request()->is('User/Userprivilege*') ? 'active' : '' }}"
                                    href="{{ url('User/Userprivilege') }}">User Privilege</a>
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
                    <i class="fas fa-database"></i>
                    <span class="links_name">Master Data <span class="collapse-icon"></span>
                </a>
                <div class="collapse {{ $isMasterDataActive ? 'show' : '' }}" id="collapseMasterDataMobile"
                    data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion">
                        <!-- Variety Master -->
                        <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 font-bold mt-2"
                            href="javascript:void(0);">Variety Master</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                            href="{{ url('Master/Variety') }}">Variety</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                            href="{{ url('Master/Subcategory') }}">Sub-Category</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                            href="{{ url('Master/ProductType') }}">Product Type</a>

                        <!-- Color Master -->
                        <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 font-bold mt-2"
                            href="javascript:void(0);">Color Master</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                            href="{{ url('Master/Color') }}">Color</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                            href="{{ url('Master/ColorCategory') }}">Color Category</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                            href="{{ url('Master/ColorGrade') }}">Color Grade</a>

                        <!-- Product Master -->
                        <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 font-bold mt-2"
                            href="javascript:void(0);">Product Master</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                            href="{{ url('Master/Shape') }}">Shape</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                            href="{{ url('Master/Cut') }}">Cut</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                            href="{{ url('Master/Grade') }}">Grade</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                            href="{{ url('Master/GradeType') }}">Grade Type</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                            href="{{ url('Master/CuttingGrade') }}">Cutting Grade</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                            href="{{ url('Master/ClarityGrade') }}">Clarity Grade</a>

                        <!-- Origin & Treatment -->
                        <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 font-bold mt-2"
                            href="javascript:void(0);">Origin & Treatment</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                            href="{{ url('Master/Origin') }}">Origin</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                            href="{{ url('Master/Treatment') }}">Treatment</a>

                        <!-- Storage & Location -->
                        <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 font-bold mt-2"
                            href="javascript:void(0);">Storage & Location</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                            href="{{ url('Master/StorageLocation') }}">Storage Location</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                            href="{{ url('Master/TrayBox') }}">Tray/Box</a>

                        <!-- Inventory -->
                        <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 font-bold mt-2"
                            href="javascript:void(0);">Inventory</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                            href="{{ url('Master/SKU') }}">SKU</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                            href="{{ url('Master/Supplier') }}">Supplier</a>

                        <!-- Company & Organization -->
                        <a class="nav-link p-0 px-3 py-1 text-sm text-gray-800 font-bold mt-2"
                            href="javascript:void(0);">Company & Organization</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                            href="{{ url('Master/CompanyType') }}">Company Type</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                            href="{{ url('Master/Country') }}">Country</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                            href="{{ url('Master/State') }}">State</a>
                        <a class="nav-link p-0 px-4 py-1 text-sm text-gray-800 hover:text-gray-900"
                            href="{{ url('Master/Role') }}">Role</a>
                    </nav>
                </div>
            </li>

        </ul>
    </div>
</div>