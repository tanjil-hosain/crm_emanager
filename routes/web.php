<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\BranchProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DasboardController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SalesReturnController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// Dashboard
Route::get('/dashboard', [DasboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'permission:view dashboard'])
    ->name('dashboard');


// Accounts
Route::get('/accounts', [DasboardController::class, 'accounts'])
    ->middleware(['auth', 'permission:view accounts'])
    ->name('accounts');


// Users
Route::middleware('auth')->group(function () {

    // Trash
    Route::get('/users/trash', [UserController::class, 'trash'])
        ->middleware('permission:view users')
        ->name('users.trash');

    // Restore
    Route::put('/users/restore/{id}', [UserController::class, 'restore'])
        ->middleware('permission:edit users')
        ->name('users.restore');

    // Force Delete
    Route::delete('/users/force-delete/{id}', [UserController::class, 'forceDelete'])
        ->middleware('permission:delete users')
        ->name('users.forceDelete');

    // Resource
    Route::resource('users', UserController::class)
        ->middlewareFor('index', 'permission:view users')
        ->middlewareFor('show', 'permission:show users')
        ->middlewareFor('create', 'permission:create users')
        ->middlewareFor('store', 'permission:create users')
        ->middlewareFor('edit', 'permission:edit users')
        ->middlewareFor('update', 'permission:edit users')
        ->middlewareFor('destroy', 'permission:delete users');
});


// Roles
Route::middleware(['auth', 'permission:roles'])->group(function () {
    Route::get('/roles/create', [RoleController::class, 'create'])
        ->name('role.create');

    Route::post('/roles/store', [RoleController::class, 'store'])
        ->name('role.store');
});


// Permissions
Route::middleware(['auth', 'permission:permissions'])->group(function () {
    Route::get('/permission/create', [PermissionController::class, 'create'])
        ->name('permission.create');

    Route::post('/permission/store', [PermissionController::class, 'store'])
        ->name('permission.store');
});


// Role & Permission
Route::middleware(['auth', 'permission:role permissions'])->group(function () {
    Route::get('role.permission/create', [RolePermissionController::class, 'create'])
        ->name('role.permission.create');

    Route::post('role.permission/store', [RolePermissionController::class, 'store'])
        ->name('role.permission.store');
});


// Settings
Route::middleware(['auth', 'permission:settings'])->group(function () {
    Route::get('/settings/index', [SettingController::class, 'index'])
        ->name('setting.index');

    Route::put('/settings/update', [SettingController::class, 'update'])
        ->name('setting.update');
});


// Customers
Route::middleware('auth')->group(function () {
    Route::resource('customers', CustomerController::class)
        ->middlewareFor('index', 'permission:view customers')
        ->middlewareFor('show', 'permission:view customers')
        ->middlewareFor('create', 'permission:create customers')
        ->middlewareFor('edit', 'permission:edit customers')
        ->middlewareFor('destroy', 'permission:delete customers');
});


// Leads
Route::middleware('auth')->group(function () {
    Route::resource('leads', LeadController::class)
        ->middlewareFor('index', 'permission:view leads')
        ->middlewareFor('show', 'permission:view leads')
        ->middlewareFor('create', 'permission:create leads')
        ->middlewareFor('edit', 'permission:edit leads')
        ->middlewareFor('destroy', 'permission:delete leads');
});


// Categories
Route::middleware('auth')->group(function () {
    Route::resource('category', CategoryController::class)
        ->middlewareFor('index', 'permission:view categories')
        ->middlewareFor('show', 'permission:view categories')
        ->middlewareFor('create', 'permission:create categories')
        ->middlewareFor('edit', 'permission:edit categories')
        ->middlewareFor('destroy', 'permission:delete categories');
});


// Subcategories
Route::middleware('auth')->group(function () {
    Route::resource('subcategory', SubcategoryController::class)
        ->middlewareFor('index', 'permission:view subcategories')
        ->middlewareFor('show', 'permission:view subcategories')
        ->middlewareFor('create', 'permission:create subcategories')
        ->middlewareFor('edit', 'permission:edit subcategories')
        ->middlewareFor('destroy', 'permission:delete subcategories');
});


// Products
Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class)
        ->middlewareFor('index', 'permission:view products')
        ->middlewareFor('show', 'permission:view products')
        ->middlewareFor('create', 'permission:create products')
        ->middlewareFor('edit', 'permission:edit products')
        ->middlewareFor('destroy', 'permission:delete products');
});


// Sales
Route::middleware('auth')->group(function () {
    Route::get('/sales/{sale}/invoice', [SaleController::class, 'invoice'])
    ->name('sales.invoice');
    Route::resource('sales', SaleController::class)
        ->middlewareFor('index', 'permission:view sales')
        ->middlewareFor('show', 'permission:view sales')
        ->middlewareFor('create', 'permission:create sales')
        ->middlewareFor('edit', 'permission:edit sales')
        ->middlewareFor('destroy', 'permission:delete sales');
});


// Payments
Route::middleware('auth')->group(function () {
    Route::resource('payments', PaymentController::class)
        ->middlewareFor('index', 'permission:view payments')
        ->middlewareFor('show', 'permission:view payments')
        ->middlewareFor('create', 'permission:create payments')
        ->middlewareFor('edit', 'permission:edit payments')
        ->middlewareFor('destroy', 'permission:delete payments');
});


// Sales Returns
Route::middleware('auth')->group(function () {

    Route::get('/sales-returns', [SalesReturnController::class, 'index'])
        ->middleware('permission:view sales returns')
        ->name('sales-returns.index');

    Route::get('/sales-returns/create', [SalesReturnController::class, 'create'])
        ->middleware('permission:create sales returns')
        ->name('sales-returns.create');

    Route::post('/sales-returns', [SalesReturnController::class, 'store'])
        ->middleware('permission:create sales returns')
        ->name('sales-returns.store');
});

//Branch
Route::middleware('auth')->group(function(){
    Route::resource('branches', BranchController::class);
    Route::resource('branches.products', BranchProductController::class);
});


require __DIR__ . '/auth.php';
