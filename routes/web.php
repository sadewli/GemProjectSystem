<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\Sales\SalesController;
use App\Http\Controllers\Sales\CustomerMemoController;
use App\Http\Controllers\Sales\QuotationController;
use App\Http\Controllers\Sales\ShippingInvoiceController;
use App\Http\Controllers\Sales\LocationTransferController;
use App\Http\Controllers\Sales\PurchaseOrderController;
use App\Http\Controllers\Sales\SupplierMemoController;
use App\Http\Controllers\Master\SkuController;
use App\Http\Controllers\Master\VarietyController;
use App\Http\Controllers\Master\ProductTypeController;
use App\Http\Controllers\Master\SubCategoryController;
use App\Http\Controllers\Master\ColorController;
use App\Http\Controllers\Master\ColorCategoryController;
use App\Http\Controllers\Master\ShapeController;
use App\Http\Controllers\Master\CutController;
use App\Http\Controllers\Master\GradeTypeController;
use App\Http\Controllers\Master\GradeController;
use App\Http\Controllers\Master\OriginController;
use App\Http\Controllers\Master\TreatmentController;
use App\Http\Controllers\Master\CuttingGradeController;
use App\Http\Controllers\Master\ClarityGradeController;
use App\Http\Controllers\Master\TrayBoxController;
use App\Http\Controllers\Master\StorageLocationController;
use App\Http\Controllers\Master\SupplierController;
use App\Http\Controllers\Master\CompanyTypeController;
use App\Http\Controllers\Master\RoleController;
use App\Http\Controllers\Master\StateController;
use App\Http\Controllers\Master\CountryController;
use App\Http\Controllers\Master\ColorGradeController;

Route::get('/', [WelcomeController::class, 'index']);
Route::get('Welcome', [WelcomeController::class, 'index']);
Route::post('Welcome/getBranchesByCompany', [WelcomeController::class, 'getBranchesByCompany'])->name('welcome.getBranchesByCompany');
Route::post('Welcome/LoginUser', [WelcomeController::class, 'LoginUser']);
Route::get('Welcome/Logout', [WelcomeController::class, 'Logout']);
Route::get('Welcome/Dashboard', [WelcomeController::class, 'Dashboard']);

Route::get('User/Useraccount', [UserController::class, 'Useraccount']);
Route::post('User/Useraccountinsertupdate', [UserController::class, 'Useraccountinsertupdate']);
Route::post('User/Useraccountedit', [UserController::class, 'Useraccountedit']);
Route::get('User/Useraccountstatus/{x}/{y}', [UserController::class, 'Useraccountstatus']);

Route::get('User/Usertype', [UserController::class, 'Usertype']);
Route::post('User/Usertypeinsertupdate', [UserController::class, 'Usertypeinsertupdate']);
Route::post('User/Usertypeedit', [UserController::class, 'Usertypeedit']);
Route::get('User/Usertypestatus/{x}/{y}', [UserController::class, 'Usertypestatus']);

Route::get('User/Userprivilege', [UserController::class, 'Userprivilege']);
Route::post('User/Userprivilegeinsertupdate', [UserController::class, 'Userprivilegeinsertupdate']);
Route::post('User/Userprivilegeedit', [UserController::class, 'Userprivilegeedit']);
Route::get('User/Userprivilegestatus/{x}/{y}', [UserController::class, 'Userprivilegestatus']);
Route::get('User/User4MenuAccess', [UserController::class, 'User4MenuAccess']);

// Additional routes will be added similarly for other controllers in the CI project, preserving the same URI patterns.

Route::get('Master/Variety', [VarietyController::class, 'index']);
Route::get('Master/ProductType', [ProductTypeController::class, 'index']);
Route::post('Master/ProductTypeinsertupdate', [ProductTypeController::class, 'insertupdate']);
Route::post('Master/ProductTypeDelete', [ProductTypeController::class, 'delete']);
Route::post('Master/Varietyinsertupdate', [VarietyController::class, 'insertupdate']);
Route::get('Master/Subcategory', [SubCategoryController::class, 'index']);
Route::post('Master/Subcategoryinsertupdate', [SubCategoryController::class, 'insertupdate']);
Route::post('Master/Subcategorydelete', [SubCategoryController::class, 'delete']);
Route::get('Master/Color', [ColorController::class, 'index']);
Route::get('Master/ColorCategory', [ColorCategoryController::class, 'index']);
Route::get('Master/Shape', [ShapeController::class, 'index']);
Route::post('Master/Shapeinsertupdate', [ShapeController::class, 'insertupdate']);
Route::post('Master/Shapeedit', [ShapeController::class, 'edit']);
Route::post('Master/Shapedelete', [ShapeController::class, 'delete']);
Route::get('Master/Cut', [CutController::class, 'index']);
Route::post('Master/Cutinsertupdate', [CutController::class, 'insertupdate']);
Route::post('Master/Cutedit', [CutController::class, 'edit']);
Route::post('Master/Cutdelete', [CutController::class, 'delete']);
Route::get('Master/GradeType', [GradeTypeController::class, 'index']);
Route::post('Master/Gradetypeinsertupdate', [GradeTypeController::class, 'insertupdate']);
Route::post('Master/Gradetypeedit', [GradeTypeController::class, 'edit']);
Route::post('Master/Gradetypedelete', [GradeTypeController::class, 'delete']);
Route::get('Master/Grade', [GradeController::class, 'index']);
Route::post('Master/Gradeinsertupdate', [GradeController::class, 'insertupdate']);
Route::post('Master/Gradeedit', [GradeController::class, 'edit']);
Route::post('Master/Gradedelete', [GradeController::class, 'delete']);
Route::get('Master/Origin', [OriginController::class, 'index']);
Route::post('Master/Origininsertupdate', [OriginController::class, 'insertupdate']);
Route::post('Master/Originedit', [OriginController::class, 'edit']);
Route::post('Master/Origindelete', [OriginController::class, 'delete']);
Route::get('Master/Treatment', [TreatmentController::class, 'index']);
Route::post('Master/Treatmentinsertupdate', [TreatmentController::class, 'insertupdate']);
Route::post('Master/Treatmentedit', [TreatmentController::class, 'edit']);
Route::post('Master/Treatmentdelete', [TreatmentController::class, 'delete']);
Route::get('Master/CuttingGrade', [CuttingGradeController::class, 'index']);
Route::post('Master/CuttingGradeinsertupdate', [CuttingGradeController::class, 'insertupdate']);
Route::post('Master/CuttingGradeedit', [CuttingGradeController::class, 'edit']);
Route::post('Master/CuttingGradedelete', [CuttingGradeController::class, 'delete']);
Route::get('Master/ClarityGrade', [ClarityGradeController::class, 'index']);
Route::post('Master/ClarityGradeinsertupdate', [ClarityGradeController::class, 'insertupdate']);
Route::post('Master/ClarityGradeedit', [ClarityGradeController::class, 'edit']);
Route::post('Master/ClarityGradedelete', [ClarityGradeController::class, 'delete']);
Route::get('Master/TrayBox', [TrayBoxController::class, 'index']);
Route::post('Master/TrayBoxinsertupdate', [TrayBoxController::class, 'insertupdate']);
Route::post('Master/TrayBoxedit', [TrayBoxController::class, 'edit']);
Route::post('Master/TrayBoxdelete', [TrayBoxController::class, 'delete']);
Route::get('Master/StorageLocation', [StorageLocationController::class, 'index']);
Route::post('Master/Storagelocationinsertupdate', [StorageLocationController::class, 'insertupdate']);
Route::post('Master/Storagelocationedit', [StorageLocationController::class, 'edit']);
Route::post('Master/Storagelocationdelete', [StorageLocationController::class, 'delete']);
Route::get('Master/Suppliers', [SupplierController::class, 'index']);
Route::post('Master/Suppliersinsertupdate', [SupplierController::class, 'insertupdate']);
Route::post('Master/Colorinsertupdate', [ColorController::class, 'insertupdate']);
Route::post('Master/Colorcategoryinsertupdate', [ColorCategoryController::class, 'insertupdate']);

Route::get('Master/CompanyType', [CompanyTypeController::class, 'index'])->name('master.companytype');
Route::post('Master/CompanyTypeinsertupdate', [CompanyTypeController::class, 'insertupdate'])->name('master.companytype.insertupdate');
Route::get('Master/CompanyTypestatus/{id}/{status}', [CompanyTypeController::class, 'status'])->name('master.companytype.status');

Route::get('Master/Sku', [SkuController::class, 'index'])->name('master.sku');
Route::post('Master/Skuinsertupdate', [SkuController::class, 'insertupdate'])->name('master.sku.insertupdate');
Route::post('Master/Skuedit', [SkuController::class, 'edit'])->name('master.sku.edit');
Route::post('Master/Skustatus', [SkuController::class, 'status'])->name('master.sku.status');
Route::post('Master/Skudelete', [SkuController::class, 'delete'])->name('master.sku.delete');

Route::get('Sales/Invoices', [SalesController::class, 'invoices'])->name('sales.invoices');
Route::get('Sales/Invoice', [SalesController::class, 'invoice'])->name('sales.invoice');
Route::get('Sales/CustomerMemo', [CustomerMemoController::class, 'index'])->name('sales.customermemo');
Route::get('Sales/CustomerMemo/new', [CustomerMemoController::class, 'show'])->name('sales.customermemo.new');
Route::get('Sales/CustomerMemo/{id}', [CustomerMemoController::class, 'show'])->name('sales.customermemo.show');
Route::get('Sales/Quotations', [QuotationController::class, 'index'])->name('sales.quotations');
Route::get('Sales/Quotations/new', [QuotationController::class, 'show'])->name('sales.quotations.new');
Route::get('Sales/Quotations/{id}', [QuotationController::class, 'show'])->name('sales.quotations.show');
Route::get('Sales/ShippingInvoices', [ShippingInvoiceController::class, 'index'])->name('sales.shippinginvoices');
Route::get('Sales/ShippingInvoices/new', [ShippingInvoiceController::class, 'show'])->name('sales.shippinginvoices.new');
Route::get('Sales/ShippingInvoices/{id}', [ShippingInvoiceController::class, 'show'])->name('sales.shippinginvoices.show');
Route::get('Sales/LocationTransfer', [LocationTransferController::class, 'index'])->name('sales.locationtransfer');
Route::get('Sales/LocationTransfer/new', [LocationTransferController::class, 'show'])->name('sales.locationtransfer.new');
Route::get('Sales/LocationTransfer/{id}', [LocationTransferController::class, 'show'])->name('sales.locationtransfer.show');
Route::get('Sales/PurchaseOrders', [PurchaseOrderController::class, 'index'])->name('sales.purchaseorders');
Route::get('Sales/PurchaseOrders/new', [PurchaseOrderController::class, 'show'])->name('sales.purchaseorders.new');
Route::get('Sales/PurchaseOrders/{id}', [PurchaseOrderController::class, 'show'])->name('sales.purchaseorders.show');
Route::get('Sales/SupplierMemos', [SupplierMemoController::class, 'index'])->name('sales.suppliermemos');
Route::get('Sales/SupplierMemos/new', [SupplierMemoController::class, 'show'])->name('sales.suppliermemos.new');
Route::get('Sales/SupplierMemos/{id}', [SupplierMemoController::class, 'show'])->name('sales.suppliermemos.show');

Route::get('Master/Role', [RoleController::class, 'index'])->name('master.role');
Route::post('Master/Roleinsertupdate', [RoleController::class, 'insertupdate'])->name('master.role.insertupdate');
Route::get('Master/Rolestatus/{id}/{status}', [RoleController::class, 'status'])->name('master.role.status');

Route::get('Master/State', [StateController::class, 'index'])->name('master.state');
Route::post('Master/Stateinsertupdate', [StateController::class, 'insertupdate'])->name('master.state.insertupdate');
Route::get('Master/Statestatus/{id}/{status}', [StateController::class, 'status'])->name('master.state.status');

Route::get('Master/Country', [CountryController::class, 'index'])->name('master.country');
Route::post('Master/Countryinsertupdate', [CountryController::class, 'insertupdate'])->name('master.country.insertupdate');
Route::get('Master/Countrystatus/{id}/{status}', [CountryController::class, 'status'])->name('master.country.status');

Route::get('Master/ColorGrade', [ColorGradeController::class, 'index'])->name('master.colorgrade');
Route::post('Master/ColorGradeinsertupdate', [ColorGradeController::class, 'insertupdate'])->name('master.colorgrade.insertupdate');
Route::post('Master/ColorGradestatus', [ColorGradeController::class, 'status'])->name('master.colorgrade.status');
Route::post('Master/ColorGradedelete', [ColorGradeController::class, 'delete'])->name('master.colorgrade.delete');


//Inventory Routes
// Product Code
Route::prefix('Inventory/productcode')->name('productcode.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Inventory\productcode::class, 'index'])->name('index');
});

// Negative Inventory Routes
Route::prefix('Inventory/negativeinventory')->name('negativeinventory.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Inventory\negativeinventory::class, 'index'])->name('index');
});

// Archived Routes
Route::prefix('Inventory/archived')->name('archived.')->group(function () {

    Route::get('/', [\App\Http\Controllers\Inventory\archived::class, 'index'])->name('index');
    Route::get('/{id}', [\App\Http\Controllers\Inventory\archived::class, 'show'])->name('show');
    Route::patch('/{id}/restore', [\App\Http\Controllers\Inventory\archived::class, 'restore'])->name('restore');
});

//Memo in routes
Route::prefix('Inventory/memoin')->name('memoin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\inventory\memoin::class, 'index'])->name('index');
    Route::get('/{id}', [\App\Http\Controllers\inventory\memoin::class, 'show'])->name('show');
    Route::patch('/{id}/restore', [\App\Http\Controllers\inventory\memoin::class, 'restore'])->name('restore');
});

//Inventory List
Route::prefix('Inventory/inventorylist')->name('inventorylist.')->group(function () {
    Route::get('/', [\App\Http\Controllers\inventory\inventorylist::class, 'index'])->name('index');
    Route::get('/{id}', [\App\Http\Controllers\inventory\inventorylist::class, 'show'])->name('show');
    Route::patch('/{id}/restore', [\App\Http\Controllers\inventory\inventorylist::class, 'restore'])->name('restore');
});

//Inventory Adjustment
Route::prefix('Inventory/inventoryadjustment')->name('inventoryadjustment.')->group(function () {
    Route::get('/', [\App\Http\Controllers\inventory\inventoryadjustment::class, 'index'])->name('index');
    Route::get('/{id}', [\App\Http\Controllers\inventory\inventoryadjustment::class, 'show'])->name('show');
    Route::patch('/{id}/restore', [\App\Http\Controllers\inventory\inventoryadjustment::class, 'restore'])->name('restore');
});

Route::prefix('Inventory/MyInventory')->name('inventory.myinventory.')->group(function () {
    Route::get('/', [InventoryController::class, 'myinventory'])->name('index');
    Route::get('/select-type', [InventoryController::class, 'selectProductType'])->name('select_type');
    Route::post('/store-type', [InventoryController::class, 'storeProductTypeSession'])->name('store_type');
    Route::get('/create', [InventoryController::class, 'create'])->name('create');
    Route::get('/new', [InventoryController::class, 'show'])->name('new');
    Route::post('/store', [InventoryController::class, 'store'])->name('store');
    Route::get('/next-sku/{productTypeId}', [InventoryController::class, 'nextSku'])->name('next_sku');
    Route::get('/{id}', [InventoryController::class, 'show'])->name('show');
});

Route::get('Inventory/MemoOut', [InventoryController::class, 'memoOut'])->name('inventory.memoout');


// CRM Routes
Route::prefix('crm')->name('crm.')->group(function () {

    //Contact Routes
    Route::get('/contacts', [\App\Http\Controllers\crm\ContactsController::class, 'index'])
        ->name('contacts.index');

    Route::get('/contacts/import', [\App\Http\Controllers\crm\ContactsController::class, 'import'])
        ->name('contacts.import');

    //Companies Routes
    Route::get('/companies', [\App\Http\Controllers\crm\CompaniesController::class, 'index'])
        ->name('companies.index');

    Route::get('/companies/import', [\App\Http\Controllers\crm\CompaniesController::class, 'import'])
        ->name('companies.import');

    Route::post('/companies', [\App\Http\Controllers\crm\CompaniesController::class, 'store'])
        ->name('companies.store');

    Route::get('/companies/{id}', [\App\Http\Controllers\crm\CompaniesController::class, 'show'])
        ->name('companies.show');

    Route::put('/companies/{id}', [\App\Http\Controllers\crm\CompaniesController::class, 'update'])
        ->name('companies.update');

    Route::delete('/companies/{id}', [\App\Http\Controllers\crm\CompaniesController::class, 'destroy'])
        ->name('companies.destroy');

    // Contacts CRUD
    Route::post('/contacts', [\App\Http\Controllers\crm\ContactsController::class, 'store'])
        ->name('contacts.store');
    Route::get('/contacts/{id}', [\App\Http\Controllers\crm\ContactsController::class, 'show'])
        ->name('contacts.show');
    Route::put('/contacts/{id}', [\App\Http\Controllers\crm\ContactsController::class, 'update'])
        ->name('contacts.update');
    Route::delete('/contacts/{id}', [\App\Http\Controllers\crm\ContactsController::class, 'destroy'])
        ->name('contacts.destroy');

    Route::get('/companies/create', function () {
        return redirect()->route('crm.companies.index', ['open_modal' => 1]);
    })->name('companies.create');

});


//Production Routes
Route::prefix('production')->name('production.')->group(function () {
    Route::get('/overview', [\App\Http\Controllers\production\overview::class, 'index'])->name('overview.index');
    Route::get('/excelsheet', [\App\Http\Controllers\production\excelsheet::class, 'index'])->name('excelsheet.index');
    Route::get('/excelsheetupload', [\App\Http\Controllers\production\excelsheetupload::class, 'index'])->name('excelsheetupload.index');
    
    // New placeholder routes for menubar items
    Route::get('/recutting', function() { return view('dashboard'); })->name('recutting');
    Route::get('/cutting', function() { return view('dashboard'); })->name('cutting');
    Route::get('/reassortment', function() { return view('dashboard'); })->name('reassortment');
    Route::get('/treatment', function() { return view('dashboard'); })->name('treatment');
    Route::get('/producttransfer', function() { return view('dashboard'); })->name('producttransfer');
});

// Missing Inventory Route
Route::get('Inventory/stocktake', function() { return view('dashboard'); })->name('inventory.stocktake');


/* Obsolete AJAX routes removed */
