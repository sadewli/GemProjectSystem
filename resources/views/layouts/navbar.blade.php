@php
    // ── Ceylon Center Gem — Privilege System ──────────────────────────────────
    $functionmenu        = trim(request()->path(), '/');
    $functionmenu2       = last(explode('/', $functionmenu));
    $menuprivilegearray  = $menuaccess ?? [];

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
                    if ($type == 1) return $array->add;
                    if ($type == 2) return $array->edit;
                    if ($type == 3) return $array->statuschange;
                    if ($type == 4) return $array->remove;
                }
            }
            return 0;
        }
    }

    // ── Add/Edit/Delete privilege checks (User pages only) ────────────────────
    $addcheck = $editcheck = $statuscheck = $deletecheck = 0;
    $menuMaps = ['Useraccount' => 2, 'Usertype' => 3, 'Userprivilege' => 4];

    if (array_key_exists($functionmenu2, $menuMaps)) {
        $id          = $menuMaps[$functionmenu2];
        $addcheck    = checkprivilege($menuprivilegearray, $id, 1);
        $editcheck   = checkprivilege($menuprivilegearray, $id, 2);
        $statuscheck = checkprivilege($menuprivilegearray, $id, 3);
        $deletecheck = checkprivilege($menuprivilegearray, $id, 4);
    }

    // ── Menu Visibility Flags ─────────────────────────────────────────────────
    // Ceylon Gem Menu IDs:
    // 2  = User Account
    // 3  = User Type
    // 4  = User Privilege
    // 5  = My Inventory
    // 6  = Memo In
    // 7  = Memo Out
    // 8  = Archived
    // 9  = Inventory List
    // 10 = Stock Take
    // 11 = Inventory Adjustment
    // 12 = Negative Inventory
    // 13 = Product Code
    // 14 = Invoice (Sales)
    // 15 = Customer Memo
    // 16 = Quotation
    // 17 = Shipping Invoice
    // 18 = Transfer Documents
    // 19 = Purchase Order (Sales)
    // 20 = Supplier Memo
    // 21 = Distributor GRN
    // 22 = CRM Companies
    // 23 = CRM Contacts
    // 24 = Production Overview
    // 25 = Re-cutting
    // 26 = Cutting
    // 27 = Re-assortment
    // 28 = Treatment
    // 29 = Product Transfer
    // 30 = Variety
    // 31 = Sub-Category
    // 32 = Color
    // 33 = Color Category
    // 34 = Shapes / Cutting
    // 35 = Grades
    // 36 = Origin & Treatment
    // 37 = Storage Locations

    // Inventory
    $myInventory       = menucheck($menuprivilegearray, 5)  == 1;
    $memoIn            = menucheck($menuprivilegearray, 6)  == 1;
    $memoOut           = menucheck($menuprivilegearray, 7)  == 1;
    $archived          = menucheck($menuprivilegearray, 8)  == 1;
    $inventoryList     = menucheck($menuprivilegearray, 9)  == 1;
    $stockTake         = menucheck($menuprivilegearray, 10) == 1;
    $invAdjustment     = menucheck($menuprivilegearray, 11) == 1;
    $negativeInventory = menucheck($menuprivilegearray, 12) == 1;
    $productCode       = menucheck($menuprivilegearray, 13) == 1;
    $showInventory     = $myInventory || $memoIn || $memoOut || $archived
                       || $inventoryList || $stockTake || $invAdjustment
                       || $negativeInventory || $productCode;

    // Sales & Purchases
    $salesInvoice    = menucheck($menuprivilegearray, 14) == 1;
    $customerMemo    = menucheck($menuprivilegearray, 15) == 1;
    $quotation       = menucheck($menuprivilegearray, 16) == 1;
    $shippingInvoice = menucheck($menuprivilegearray, 17) == 1;
    $transferDocs    = menucheck($menuprivilegearray, 18) == 1;
    $purchaseOrder   = menucheck($menuprivilegearray, 19) == 1;
    $supplierMemo    = menucheck($menuprivilegearray, 20) == 1;
    $distGRN         = menucheck($menuprivilegearray, 21) == 1;
    $showSales       = $salesInvoice || $customerMemo || $quotation || $shippingInvoice
                     || $transferDocs || $purchaseOrder || $supplierMemo || $distGRN;

    // CRM
    $crmCompanies = menucheck($menuprivilegearray, 22) == 1;
    $crmContacts  = menucheck($menuprivilegearray, 23) == 1;
    $showCRM      = $crmCompanies || $crmContacts;

    // Production
    $prodOverview     = menucheck($menuprivilegearray, 24) == 1;
    $prodReCutting    = menucheck($menuprivilegearray, 25) == 1;
    $prodCutting      = menucheck($menuprivilegearray, 26) == 1;
    $prodReAssortment = menucheck($menuprivilegearray, 27) == 1;
    $prodTreatment    = menucheck($menuprivilegearray, 28) == 1;
    $prodTransfer     = menucheck($menuprivilegearray, 29) == 1;
    $prodExcelSheet   = menucheck($menuprivilegearray, 38) == 1;
    $prodExcelUpload  = menucheck($menuprivilegearray, 39) == 1;
    $showProduction   = $prodOverview || $prodReCutting || $prodCutting
                      || $prodReAssortment || $prodTreatment || $prodTransfer
                      || $prodExcelSheet || $prodExcelUpload;

    // System Users
    $userAccount     = menucheck($menuprivilegearray, 2) == 1;
    $userType        = menucheck($menuprivilegearray, 3) == 1;
    $userPrivilege   = menucheck($menuprivilegearray, 4) == 1;
    $showSystemUsers = $userAccount || $userType || $userPrivilege;

    // Master Data
    $masterVariety    = menucheck($menuprivilegearray, 30) == 1;
    $masterSubCat     = menucheck($menuprivilegearray, 31) == 1;
    $masterColor      = menucheck($menuprivilegearray, 32) == 1;
    $masterColorCat   = menucheck($menuprivilegearray, 33) == 1;
    $masterShapeCut   = menucheck($menuprivilegearray, 34) == 1;
    $masterGrades     = menucheck($menuprivilegearray, 35) == 1;
    $masterOrigin     = menucheck($menuprivilegearray, 36) == 1;
    $masterStorage    = menucheck($menuprivilegearray, 37) == 1;
    $masterCompType   = menucheck($menuprivilegearray, 40) == 1;
    $masterRole       = menucheck($menuprivilegearray, 41) == 1;
    $masterState      = menucheck($menuprivilegearray, 42) == 1;
    $masterCountry    = menucheck($menuprivilegearray, 43) == 1;
    $showMasterData   = $masterVariety || $masterSubCat || $masterColor || $masterColorCat
                      || $masterShapeCut || $masterGrades || $masterOrigin || $masterStorage
                      || $masterCompType || $masterRole || $masterState || $masterCountry;
@endphp

<textarea class="hidden" id="actiontext">{{ session('msg') }}</textarea>

<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    {{-- begin::Menu wrapper --}}
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
        {{-- begin::Scroll wrapper --}}
        <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3"
            data-kt-scroll="true"
            data-kt-scroll-activate="true"
            data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
            data-kt-scroll-wrappers="#kt_app_sidebar_menu"
            data-kt-scroll-offset="5px"
            data-kt-scroll-save-state="true">

            {{-- begin::Menu --}}
            <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
                id="#kt_app_sidebar_menu"
                data-kt-menu="true"
                data-kt-menu-expand="false">


                {{-- ══════════════════════════════════════════
                     DASHBOARD
                ══════════════════════════════════════════ --}}
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


                {{-- ══════════════════════════════════════════
                     INVENTORY
                ══════════════════════════════════════════ --}}
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


                {{-- ══════════════════════════════════════════
                     SALES & PURCHASES
                ══════════════════════════════════════════ --}}
                @if ($showSales)
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion{{ request()->is('Distributor/*') ? ' show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-chart-line-star fs-2">
                                    <span class="path1"></span><span class="path2"></span><span class="path3"></span>
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
                            @if ($distGRN)
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


                {{-- ══════════════════════════════════════════
                     CRM
                ══════════════════════════════════════════ --}}
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


                {{-- ══════════════════════════════════════════
                     PRODUCTION
                ══════════════════════════════════════════ --}}
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
                            @if ($prodExcelSheet)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('production/excelsheet*') ? ' active' : '' }}"
                                        href="{{ url('production/excelsheet') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Excel Sheet</span>
                                    </a>
                                </div>
                            @endif
                            @if ($prodExcelUpload)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('production/excelsheetupload*') ? ' active' : '' }}"
                                        href="{{ url('production/excelsheetupload') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Excel Sheet Upload</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif


                {{-- ══════════════════════════════════════════
                     SYSTEM USERS
                ══════════════════════════════════════════ --}}
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


                {{-- ══════════════════════════════════════════
                     MASTER DATA
                ══════════════════════════════════════════ --}}
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
                            @if ($masterCompType)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Master/CompanyType*') ? ' active' : '' }}"
                                        href="{{ url('Master/CompanyType') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Company Type</span>
                                    </a>
                                </div>
                            @endif
                            @if ($masterRole)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Master/Role*') ? ' active' : '' }}"
                                        href="{{ url('Master/Role') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Role</span>
                                    </a>
                                </div>
                            @endif
                            @if ($masterState)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Master/State*') ? ' active' : '' }}"
                                        href="{{ url('Master/State') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">State</span>
                                    </a>
                                </div>
                            @endif
                            @if ($masterCountry)
                                <div class="menu-item">
                                    <a class="menu-link{{ request()->is('Master/Country*') ? ' active' : '' }}"
                                        href="{{ url('Master/Country') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Country</span>
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
