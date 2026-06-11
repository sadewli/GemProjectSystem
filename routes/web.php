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

Route::get('Master/Variety', [MasterController::class, 'variety']);
Route::get('Master/Subcategory', [MasterController::class, 'subcategory']);
Route::get('Master/Color', [MasterController::class, 'color']);
Route::get('Master/ColorCategory', [MasterController::class, 'color_category']);
Route::get('Master/ShapeCut', [MasterController::class, 'shape_cut']);
Route::get('Master/Grade', [MasterController::class, 'grade']);
Route::get('Master/OriginTreatment', [MasterController::class, 'origin_treatment']);
Route::get('Master/StorageLocation', [MasterController::class, 'storage_location']);

Route::get('Master/CompanyType', [MasterController::class, 'companytype'])->name('master.companytype');
Route::post('Master/CompanyTypeinsertupdate', [MasterController::class, 'companytype_insertupdate'])->name('master.companytype.insertupdate');
Route::get('Master/CompanyTypestatus/{id}/{status}', [MasterController::class, 'companytype_status'])->name('master.companytype.status');

Route::get('Master/Role', [MasterController::class, 'role'])->name('master.role');
Route::post('Master/Roleinsertupdate', [MasterController::class, 'role_insertupdate'])->name('master.role.insertupdate');
Route::get('Master/Rolestatus/{id}/{status}', [MasterController::class, 'role_status'])->name('master.role.status');

Route::get('Master/State', [MasterController::class, 'state'])->name('master.state');
Route::post('Master/Stateinsertupdate', [MasterController::class, 'state_insertupdate'])->name('master.state.insertupdate');
Route::get('Master/Statestatus/{id}/{status}', [MasterController::class, 'state_status'])->name('master.state.status');

Route::get('Master/Country', [MasterController::class, 'country'])->name('master.country');
Route::post('Master/Countryinsertupdate', [MasterController::class, 'country_insertupdate'])->name('master.country.insertupdate');
Route::get('Master/Countrystatus/{id}/{status}', [MasterController::class, 'country_status'])->name('master.country.status');


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


