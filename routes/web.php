<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Middleware\AuthenticateMiddleware;
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

Route::get('/', function () 
{
    return view('home');
})->name('backend.home');

// Route::get('login', function () {
//     return view('backend.home');
// });

/*BACKEND ROUTES*/
Route::get('dashboard/index', [DashboardController::class, 'index'])->name('dashboard.index')->middleware('auth', 'role:admin');

/*USER */
Route::get('user/index', [UserController::class, 'index'])->name('user.index')->middleware('auth', 'role:admin');


//Đăng nhập, đăng xuất
Route::prefix('auth')->group(function () {
    Route::get('admin', [AuthController::class, 'index'])->name('auth.admin')->middleware('login');
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
});


//Quản lý thành viên
Route::prefix('user')->group(function () {
    //Thêm
    Route::get('user/create', [UserController::class, 'create'])->name('user.addUser')->middleware('auth', 'role:admin');
    Route::post('user/store', [UserController::class, 'store'])->name('user.store')->middleware('auth', 'role:admin');

    //Sửa
    Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit')->middleware('auth', 'role:admin');
    Route::put('user/update/{id}', [UserController::class, 'update'])->name('user.update')->middleware('auth', 'role:admin');

    //Xóa
    Route::delete('user/{id}', [UserController::class, 'destroy'])->name('user.destroy')->middleware('auth', 'role:admin');

    //Xóa nhiều
    Route::delete('user/bulk-delete', [UserController::class, 'bulkDelete'])->name('user.bulkDelete')->middleware('auth', 'role:admin');

    //Active_user
    Route::post('user/toggle-status', [App\Http\Controllers\Backend\UserController::class, 'toggleStatus'])->name('user.toggleStatus')->middleware('role:admin');
});


// Profile routes
Route::prefix('settings')->group(function () {
    Route::get('settings', [UserController::class, 'settings'])->name('settings')->middleware('auth');
    Route::put('settings/update', [UserController::class, 'updateProfile'])->name('settings.update')->middleware('auth');
    Route::put('settings/password', [UserController::class, 'changePassword'])->name('settings.password')->middleware('auth');
    Route::post('settings/language', [UserController::class, 'changeLanguage'])->name('settings.language')->middleware('auth');
    Route::post('settings/privacy', [UserController::class, 'updatePrivacy'])->name('settings.privacy')->middleware('auth');
});


//Quản lý danh mục
Route::prefix('category')->group(function () {
    // Phông Chỉnh Lý
    Route::get('fonds', [App\Http\Controllers\Backend\CategoryController::class, 'fonds'])->name('category.fonds')->middleware('auth', 'role:admin');
    Route::get('fonds/create', [App\Http\Controllers\Backend\CategoryController::class, 'createFond'])->name('category.fonds.create')->middleware('auth', 'role:admin');
    Route::post('fonds', [App\Http\Controllers\Backend\CategoryController::class, 'storeFond'])->name('category.fonds.store')->middleware('auth', 'role:admin');

    // Danh Mục Tài Liệu
    Route::get('categories', [App\Http\Controllers\Backend\CategoryController::class, 'categories'])->name('category.categories')->middleware('auth', 'role:admin');
    Route::get('categories/create', [App\Http\Controllers\Backend\CategoryController::class, 'createCategory'])->name('category.categories.create')->middleware('auth', 'role:admin');
    Route::post('categories', [App\Http\Controllers\Backend\CategoryController::class, 'storeCategory'])->name('category.categories.store')->middleware('auth', 'role:admin');

    // Kho Lưu Trữ
    Route::get('warehouses', [App\Http\Controllers\Backend\CategoryController::class, 'warehouses'])->name('category.warehouses')->middleware('auth', 'role:admin');
    Route::get('warehouses/create', [App\Http\Controllers\Backend\CategoryController::class, 'createWarehouse'])->name('category.warehouses.create')->middleware('auth', 'role:admin');
    Route::post('warehouses', [App\Http\Controllers\Backend\CategoryController::class, 'storeWarehouse'])->name('category.warehouses.store')->middleware('auth', 'role:admin');

    // Kệ Trong Kho
    Route::get('shelves', [App\Http\Controllers\Backend\CategoryController::class, 'shelves'])->name('category.shelves')->middleware('auth', 'role:admin');
    Route::get('shelves/create', [App\Http\Controllers\Backend\CategoryController::class, 'createShelf'])->name('category.shelves.create')->middleware('auth', 'role:admin');
    Route::post('shelves', [App\Http\Controllers\Backend\CategoryController::class, 'storeShelf'])->name('category.shelves.store')->middleware('auth', 'role:admin');
});




