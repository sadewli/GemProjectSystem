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
use App\Http\Controllers\DistributorGRNController;
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

// Additional routes will be added similarly for other controllers in the CI project, preserving the same URI patterns.

Route::get('Master/Variety', [MasterController::class, 'variety']);
Route::get('Master/Subcategory', [MasterController::class, 'subcategory']);
Route::get('Master/Color', [MasterController::class, 'color']);
Route::get('Master/ColorCategory', [MasterController::class, 'color_category']);
Route::get('Master/ShapeCut', [MasterController::class, 'shape_cut']);
Route::get('Master/Grade', [MasterController::class, 'grade']);
Route::get('Master/OriginTreatment', [MasterController::class, 'origin_treatment']);
Route::get('Master/StorageLocation', [MasterController::class, 'storage_location']);


Route::get('Distributor/GRN', [DistributorGRNController::class, 'index'])->name('distributor.grn');
Route::get('Distributor/GRN/list', [DistributorGRNController::class, 'list'])->name('distributor.grn.list');
Route::get('Distributor/GRN/getConfirmedPO', [DistributorGRNController::class, 'getConfirmedPO'])->name('distributor.grn.getconfirmedpo');
Route::post('Distributor/GRN/getPODetails', [DistributorGRNController::class, 'getPODetails'])->name('distributor.grn.getpodetails');
Route::post('Distributor/GRN/store', [DistributorGRNController::class, 'store'])->name('distributor.grn.store');
Route::post('Distributor/GRN/view', [DistributorGRNController::class, 'view'])->name('distributor.grn.view');
Route::post('Distributor/GRN/updateStatus', [DistributorGRNController::class, 'updateStatus'])->name('distributor.grn.updatestatus');
Route::post('Distributor/GRN/transferStock', [DistributorGRNController::class, 'transferStock'])->name('distributor.grn.transferstock');
Route::post('Distributor/GRN/delete', [DistributorGRNController::class, 'delete'])->name('distributor.grn.delete');


//Inventory Routes
// Product Code
Route::prefix('productcode')->name('productcode.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Inventory\productcode::class, 'index'])->name('index');
});

// Negative Inventory Routes
Route::prefix('negativeinventory')->name('negativeinventory.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Inventory\negativeinventory::class, 'index'])->name('index');
});

// Archived Routes
Route::prefix('archived')->name('archived.')->group(function () {

    Route::get('/', [\App\Http\Controllers\Inventory\archived::class, 'index'])->name('index');
    Route::get('/{id}', [\App\Http\Controllers\Inventory\archived::class, 'show'])->name('show');
    Route::patch('/{id}/restore', [\App\Http\Controllers\Inventory\archived::class, 'restore'])->name('restore');
});

//Memo in routes
Route::prefix('memoin')->name('memoin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\inventory\memoin::class, 'index'])->name('index');
    Route::get('/{id}', [\App\Http\Controllers\inventory\memoin::class, 'show'])->name('show');
    Route::patch('/{id}/restore', [\App\Http\Controllers\inventory\memoin::class, 'restore'])->name('restore');
});

//Inventory List
Route::prefix('inventorylist')->name('inventorylist.')->group(function () {
    Route::get('/', [\App\Http\Controllers\inventory\inventorylist::class, 'index'])->name('index');
    Route::get('/{id}', [\App\Http\Controllers\inventory\inventorylist::class, 'show'])->name('show');
    Route::patch('/{id}/restore', [\App\Http\Controllers\inventory\inventorylist::class, 'restore'])->name('restore');
});

//Inventory Adjustment
Route::prefix('inventoryadjustment')->name('inventoryadjustment.')->group(function () {
    Route::get('/', [\App\Http\Controllers\inventory\inventoryadjustment::class, 'index'])->name('index');
    Route::get('/{id}', [\App\Http\Controllers\inventory\inventoryadjustment::class, 'show'])->name('show');
    Route::patch('/{id}/restore', [\App\Http\Controllers\inventory\inventoryadjustment::class, 'restore'])->name('restore');
});

Route::prefix('Inventory/MyInventory')->name('inventory.myinventory.')->group(function () {
    Route::get('/', [InventoryController::class, 'myinventory'])->name('index');
    Route::get('/{id}', [InventoryController::class, 'show'])->name('show');
    Route::get('/new', [InventoryController::class, 'show'])->name('new');
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

    // Dummy routes to prevent blade errors since project is only UI for now
    Route::post('/contacts', function () {
        return back();
    })->name('contacts.store');
    Route::post('/companies', function () {
        return back();
    })->name('companies.store');
    Route::get('/companies/create', function () {
        return back();
    })->name('companies.create');
    Route::get('/companies/{id}', function () {
        return back();
    })->name('companies.show');

});


//Production Routes
Route::prefix('production')->name('production.')->group(function () {
    Route::get('/overview',         [\App\Http\Controllers\production\overview::class,         'index'])->name('overview.index');
    Route::get('/excelsheet',       [\App\Http\Controllers\production\excelsheet::class,       'index'])->name('excelsheet.index');
    Route::get('/excelsheetupload', [\App\Http\Controllers\production\excelsheetupload::class, 'index'])->name('excelsheetupload.index');
});


