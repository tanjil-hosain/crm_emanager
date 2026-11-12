<?php

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
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SubcategoryController;
// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('crm_emanager.backend.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DasboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/accounts', [DasboardController::class, 'accounts'])->name('accounts');
});

Route::middleware('auth')->group(function () {

    // Trash Routes
    Route::get('/users/trash', [UserController::class, 'trash'])
        ->name('users.trash');

    Route::put('/users/restore/{id}', [UserController::class, 'restore'])
        ->name('users.restore');

    Route::delete('/users/force-delete/{id}', [UserController::class, 'forceDelete'])
        ->name('users.forceDelete');

    // Resource Route
    Route::resource('users', UserController::class)->middleware('permission:view users');


});


    // //Role
    Route::middleware('auth')->group(function(){
         Route::get('/roles/create', [RoleController::class, 'create'])->name('role.create');
         Route::post('/roles/store', [RoleController::class, 'store'])->name('role.store');
    })->middleware('permission::roles');

    //Permission
    Route::middleware('auth')->group(function(){
        Route::get('/permission/create', [PermissionController::class, 'create'])->name('permission.create');
        Route::post('/permission/store', [PermissionController::class, 'store'])->name('permission.store');
    })->middleware('permission:permissions');


    //Role and Permission

    Route::middleware('auth')->group(function(){
        Route::get('role.permission/create', [RolePermissionController::class, 'create'])->name('role.permission.create');

        Route::post('role.permission/store', [RolePermissionController::class ,'store'])->name('role.permission.store');
    });

    //Site Settings
    Route::middleware('auth')->group(function(){
        Route::get('/settings/index', [SettingController::class, 'index'])->name('setting.index');
        Route::put('/settings/update', [SettingController::class, 'update'])->name('setting.update');
    });

    //Customer
    Route::middleware('auth')->group(function(){
        Route::resource('customers', CustomerController::class);
    });

    //LEADS
   Route::middleware('auth')->group(function(){
     Route::resource('leads', LeadController::class);
   });

   //Categorry
   Route::middleware('auth')->group(function(){
    Route::resource('category', CategoryController::class);
   });

   //Subcategory
   Route::middleware('auth')->group(function(){
    Route::resource('subcategory', SubcategoryController::class);
   });

   //Products
   Route::middleware('auth')->group(function(){
    Route::resource('products', ProductController::class);
   });

   //Sales
   Route::middleware('auth')->group(function(){
    Route::resource('sales', SaleController::class);
   });

   //Payment
   Route::middleware('auth')->group(function(){
    Route::resource('payments', PaymentController::class);
   });




// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
