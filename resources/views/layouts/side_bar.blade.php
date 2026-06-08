@php
    // -------------------------------------------------------
    // Permission helpers (Ceylon Center Gem logic preserved)
    // -------------------------------------------------------
    $menuprivilegearray = $menuaccess ?? [];
    $GLOBALS['menuprivilegearray'] = $menuprivilegearray;

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

    if (!function_exists('canAccessMenu')) {
        function canAccessMenu($menuID)
        {
            global $menuprivilegearray;
            return menucheck($menuprivilegearray, $menuID);
        }
    }

    // -------------------------------------------------------
    // Menu IDs — Ceylon Center Gem
    // -------------------------------------------------------
    // 1  = Dashboard
    // 2  = User Account
    // 3  = User Type
    // 4  = User Privilege
    // 5  = Inventory - My Inventory
    // 6  = Inventory - Memo In
    // 7  = Inventory - Memo Out
    // 8  = Inventory - Archived
    // 9  = Inventory - Inventory List
    // 10 = Inventory - Stock Take
    // 11 = Inventory - Inventory Adjustment
    // 12 = Inventory - Negative Inventory
    // 13 = Inventory - Product Code
    // 14 = Sales - Invoice
    // 15 = Sales - Customer Memo
    // 16 = Sales - Quotation
    // 17 = Sales - Shipping Invoice
    // 18 = Sales - Transfer Documents
    // 19 = Sales - Purchase Order
    // 20 = Sales - Supplier Memo
    // 21 = Sales - Distributor GRN
    // 22 = CRM - Companies
    // 23 = CRM - Contacts
    // 24 = Production - Overview
    // 25 = Production - Re-cutting
    // 26 = Production - Cutting
    // 27 = Production - Re-assortment
    // 28 = Production - Treatment
    // 29 = Production - Product Transfer
    // 30 = Master - Variety
    // 31 = Master - Sub-Category
    // 32 = Master - Color
    // 33 = Master - Color Category
    // 34 = Master - Shapes/Cutting
    // 35 = Master - Grades
    // 36 = Master - Origin & Treatment
    // 37 = Master - Storage Locations

    // -------------------------------------------------------
    // Inventory
    // -------------------------------------------------------
    $myInventory        = canAccessMenu(5);
    $memoIn             = canAccessMenu(6);
    $memoOut            = canAccessMenu(7);
    $archived           = canAccessMenu(8);
    $inventoryList      = canAccessMenu(9);
    $stockTake          = canAccessMenu(10);
    $invAdjustment      = canAccessMenu(11);
    $negativeInventory  = canAccessMenu(12);
    $productCode        = canAccessMenu(13);

    $showInventory = $myInventory || $memoIn || $memoOut || $archived ||
                     $inventoryList || $stockTake || $invAdjustment ||
                     $negativeInventory || $productCode;

    // -------------------------------------------------------
    // Sales & Purchases
    // -------------------------------------------------------
    $salesInvoice       = canAccessMenu(14);
    $customerMemo       = canAccessMenu(15);
    $quotation          = canAccessMenu(16);
    $shippingInvoice    = canAccessMenu(17);
    $transferDocs       = canAccessMenu(18);
    $purchaseOrder      = canAccessMenu(19);
    $supplierMemo       = canAccessMenu(20);
    $distributorGRN     = canAccessMenu(21);

    $showSales = $salesInvoice || $customerMemo || $quotation || $shippingInvoice ||
                 $transferDocs || $purchaseOrder || $supplierMemo || $distributorGRN;

    // -------------------------------------------------------
    // CRM
    // -------------------------------------------------------
    $crmCompanies   = canAccessMenu(22);
    $crmContacts    = canAccessMenu(23);
    $showCRM        = $crmCompanies || $crmContacts;

    // -------------------------------------------------------
    // Production
    // -------------------------------------------------------
    $prodOverview       = canAccessMenu(24);
    $prodReCutting      = canAccessMenu(25);
    $prodCutting        = canAccessMenu(26);
    $prodReAssortment   = canAccessMenu(27);
    $prodTreatment      = canAccessMenu(28);
    $prodTransfer       = canAccessMenu(29);

    $showProduction = $prodOverview || $prodReCutting || $prodCutting ||
                      $prodReAssortment || $prodTreatment || $prodTransfer;

    // -------------------------------------------------------
    // System Users
    // -------------------------------------------------------
    $userAccount    = canAccessMenu(2);
    $userType       = canAccessMenu(3);
    $userPrivilege  = canAccessMenu(4);
    $showSystemUsers = $userAccount || $userType || $userPrivilege;

    // -------------------------------------------------------
    // Master Data
    // -------------------------------------------------------
    $masterVariety      = canAccessMenu(30);
    $masterSubCat       = canAccessMenu(31);
    $masterColor        = canAccessMenu(32);
    $masterColorCat     = canAccessMenu(33);
    $masterShapeCut     = canAccessMenu(34);
    $masterGrades       = canAccessMenu(35);
    $masterOrigin       = canAccessMenu(36);
    $masterStorage      = canAccessMenu(37);

    $showMasterData = $masterVariety || $masterSubCat || $masterColor || $masterColorCat ||
                      $masterShapeCut || $masterGrades || $masterOrigin || $masterStorage;
@endphp

<textarea class="hidden" id="actiontext">{{ session('msg') }}</textarea>

<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
        <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3"
            data-kt-scroll="true"
            data-kt-scroll-activate="true"
            data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
            data-kt-scroll-wrappers="#kt_app_sidebar_menu"
            data-kt-scroll-offset="5px"
            data-kt-scroll-save-state="true">

            <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
                id="#kt_app_sidebar_menu"
                data-kt-menu="true"
                data-kt-menu-expand="false">

                {{-- ===================== DASHBOARD ===================== --}}
                <div class="menu-item">
                    <a class="menu-link{{ request()->is('Welcome/Dashboard*') || request()->is('Welcome') || request()->is('/') ? ' active' : '' }}"
                        href="{{ url('Welcome/Dashboard') }}">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-element-11 fs-2">
                                <span class="path1"></span><span class="path2"></span>
                                <span class="path3"></span><span class="path4"></span>
                            </i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>

                {{-- ===================== INVENTORY ===================== --}}
                @if ($showInventory)
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion{{ request()->is('Inventory/*') ? ' show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-package fs-2">
                                    <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                                </i>
                            </span>
                            <span class="menu-title">Inventory</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            @if ($myInventory)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Inventory/MyInventory*') ? ' active' : '' }}"
                                        href="{{ url('Inventory/MyInventory') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">My Inventory</span>
                                    </a>
                                </div>
                            @endif
                            @if ($memoIn)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Inventory/memoin*') ? ' active' : '' }}"
                                        href="{{ url('Inventory/memoin') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Memo In</span>
                                    </a>
                                </div>
                            @endif
                            @if ($memoOut)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Inventory/memoout*') ? ' active' : '' }}"
                                        href="{{ url('Inventory/memoout') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Memo Out</span>
                                    </a>
                                </div>
                            @endif
                            @if ($archived)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Inventory/archived*') ? ' active' : '' }}"
                                        href="{{ url('Inventory/archived') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Archived</span>
                                    </a>
                                </div>
                            @endif
                            @if ($inventoryList)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Inventory/inventorylist*') ? ' active' : '' }}"
                                        href="{{ url('Inventory/inventorylist') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Inventory List</span>
                                    </a>
                                </div>
                            @endif
                            @if ($stockTake)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Inventory/stocktake*') ? ' active' : '' }}"
                                        href="{{ url('Inventory/stocktake') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Stock Take</span>
                                    </a>
                                </div>
                            @endif
                            @if ($invAdjustment)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Inventory/inventoryadjustment*') ? ' active' : '' }}"
                                        href="{{ url('Inventory/inventoryadjustment') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Inventory Adjustment</span>
                                    </a>
                                </div>
                            @endif
                            @if ($negativeInventory)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Inventory/negativeinventory*') ? ' active' : '' }}"
                                        href="{{ url('Inventory/negativeinventory') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Negative Inventory</span>
                                    </a>
                                </div>
                            @endif
                            @if ($productCode)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Inventory/productcode*') ? ' active' : '' }}"
                                        href="{{ url('Inventory/productcode') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Product Code</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- ===================== SALES & PURCHASES ===================== --}}
                @if ($showSales)
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion{{ request()->is('Distributor/*') ? ' show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-chart-line fs-2">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                            </span>
                            <span class="menu-title">Sales & Purchases</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            @if ($salesInvoice)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Distributor/Invoice*') ? ' active' : '' }}"
                                        href="{{ url('Distributor/Invoice') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Invoice</span>
                                    </a>
                                </div>
                            @endif
                            @if ($customerMemo)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Distributor/CustomerMemo*') ? ' active' : '' }}"
                                        href="{{ url('Distributor/CustomerMemo') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Customer Memo</span>
                                    </a>
                                </div>
                            @endif
                            @if ($quotation)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Distributor/Quotation*') ? ' active' : '' }}"
                                        href="{{ url('Distributor/Quotation') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Quotation</span>
                                    </a>
                                </div>
                            @endif
                            @if ($shippingInvoice)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Distributor/ShippingInvoice*') ? ' active' : '' }}"
                                        href="{{ url('Distributor/ShippingInvoice') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Shipping Invoice</span>
                                    </a>
                                </div>
                            @endif
                            @if ($transferDocs)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Distributor/TransferDocuments*') ? ' active' : '' }}"
                                        href="{{ url('Distributor/TransferDocuments') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Transfer Documents</span>
                                    </a>
                                </div>
                            @endif
                            @if ($purchaseOrder)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Distributor/PurchaseOrder*') ? ' active' : '' }}"
                                        href="{{ url('Distributor/PurchaseOrder') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Purchase Order</span>
                                    </a>
                                </div>
                            @endif
                            @if ($supplierMemo)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Distributor/SupplierMemo*') ? ' active' : '' }}"
                                        href="{{ url('Distributor/SupplierMemo') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Supplier Memo</span>
                                    </a>
                                </div>
                            @endif
                            @if ($distributorGRN)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Distributor/GRN*') ? ' active' : '' }}"
                                        href="{{ url('Distributor/GRN') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Distributor GRN</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- ===================== CRM ===================== --}}
                @if ($showCRM)
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion{{ request()->is('crm/*') ? ' show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-address-book fs-2">
                                    <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                                </i>
                            </span>
                            <span class="menu-title">CRM</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            @if ($crmCompanies)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('crm/companies*') ? ' active' : '' }}"
                                        href="{{ url('crm/companies') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Companies</span>
                                    </a>
                                </div>
                            @endif
                            @if ($crmContacts)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('crm/contacts*') ? ' active' : '' }}"
                                        href="{{ url('crm/contacts') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Contact</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- ===================== PRODUCTION ===================== --}}
                @if ($showProduction)
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion{{ request()->is('production/*') ? ' show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-setting-4 fs-2">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                            </span>
                            <span class="menu-title">Production</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            @if ($prodOverview)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('production/overview*') ? ' active' : '' }}"
                                        href="{{ url('production/overview') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Overview</span>
                                    </a>
                                </div>
                            @endif
                            @if ($prodReCutting)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('production/recutting*') ? ' active' : '' }}"
                                        href="{{ url('production/recutting') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Re-cutting</span>
                                    </a>
                                </div>
                            @endif
                            @if ($prodCutting)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('production/cutting*') ? ' active' : '' }}"
                                        href="{{ url('production/cutting') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Cutting</span>
                                    </a>
                                </div>
                            @endif
                            @if ($prodReAssortment)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('production/reassortment*') ? ' active' : '' }}"
                                        href="{{ url('production/reassortment') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Re-assortment</span>
                                    </a>
                                </div>
                            @endif
                            @if ($prodTreatment)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('production/treatment*') ? ' active' : '' }}"
                                        href="{{ url('production/treatment') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Treatment</span>
                                    </a>
                                </div>
                            @endif
                            @if ($prodTransfer)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('production/producttransfer*') ? ' active' : '' }}"
                                        href="{{ url('production/producttransfer') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Product Transfer</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- ===================== SYSTEM USERS ===================== --}}
                @if ($showSystemUsers)
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion{{ request()->is('User/*') ? ' show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-user fs-2">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                            </span>
                            <span class="menu-title">System Users</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            @if ($userAccount)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('User/Useraccount*') ? ' active' : '' }}"
                                        href="{{ url('User/Useraccount') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">User Account</span>
                                    </a>
                                </div>
                            @endif
                            @if ($userType)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('User/Usertype*') ? ' active' : '' }}"
                                        href="{{ url('User/Usertype') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">User Type</span>
                                    </a>
                                </div>
                            @endif
                            @if ($userPrivilege)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('User/Userprivilege*') ? ' active' : '' }}"
                                        href="{{ url('User/Userprivilege') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">User Privilege</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- ===================== MASTER DATA ===================== --}}
                @if ($showMasterData)
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion{{ request()->is('Master/*') ? ' show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-some-files fs-2">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                            </span>
                            <span class="menu-title">Master Data</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            @if ($masterVariety)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Master/Variety*') ? ' active' : '' }}"
                                        href="{{ url('Master/Variety') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Variety</span>
                                    </a>
                                </div>
                            @endif
                            @if ($masterSubCat)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Master/Subcategory*') ? ' active' : '' }}"
                                        href="{{ url('Master/Subcategory') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Sub-Category</span>
                                    </a>
                                </div>
                            @endif
                            @if ($masterColor)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Master/Color*') && !request()->is('Master/ColorCategory*') ? ' active' : '' }}"
                                        href="{{ url('Master/Color') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Color</span>
                                    </a>
                                </div>
                            @endif
                            @if ($masterColorCat)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Master/ColorCategory*') ? ' active' : '' }}"
                                        href="{{ url('Master/ColorCategory') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Color Category</span>
                                    </a>
                                </div>
                            @endif
                            @if ($masterShapeCut)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Master/ShapeCut*') ? ' active' : '' }}"
                                        href="{{ url('Master/ShapeCut') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Shapes / Cutting</span>
                                    </a>
                                </div>
                            @endif
                            @if ($masterGrades)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Master/Grade*') ? ' active' : '' }}"
                                        href="{{ url('Master/Grade') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Grades</span>
                                    </a>
                                </div>
                            @endif
                            @if ($masterOrigin)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Master/OriginTreatment*') ? ' active' : '' }}"
                                        href="{{ url('Master/OriginTreatment') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Origin &amp; Treatment</span>
                                    </a>
                                </div>
                            @endif
                            @if ($masterStorage)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Master/StorageLocation*') ? ' active' : '' }}"
                                        href="{{ url('Master/StorageLocation') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Storage Locations</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

            </div>
            {{-- end::Menu --}}
        </div>
        {{-- end::Scroll wrapper --}}
    </div>
    {{-- end::Menu wrapper --}}
</div>
