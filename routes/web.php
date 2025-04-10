<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\CategoryController;
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
// Route::get('dashboard', [DashboardController::class, 'userDashboard'])->name('dashboard')->middleware('auth');

/*USER */
Route::get('user/index', [UserController::class, 'index'])->name('user.index')->middleware('auth', 'role:admin');


//Đăng nhập, đăng xuất
Route::prefix('auth')->group(function () {
    Route::get('admin', [AuthController::class, 'index'])->name('auth.admin')->middleware('login');
    Route::get('login', [AuthController::class, 'index'])->name('auth.loginForm');
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
    Route::post('user/toggle-status', [UserController::class, 'toggleStatus'])->name('user.toggleStatus')->middleware('role:admin');
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
    // API routes for location
    Route::get('/districts/{provinceId}', [CategoryController::class, 'getDistricts'])->name('api.districts')->middleware('auth');
    Route::get('/wards/{districtId}', [CategoryController::class, 'getWards'])->name('api.wards')->middleware('auth');

    // Phông Chỉnh Lý
    Route::get('fonds', [CategoryController::class, 'fonds'])->name('category.fonds')->middleware('auth', 'role:admin');
    Route::get('fonds/create', [CategoryController::class, 'createFond'])->name('category.fonds.create')->middleware('auth', 'role:admin');
    Route::post('fonds', [CategoryController::class, 'storeFond'])->name('category.fonds.store')->middleware('auth', 'role:admin');
    Route::get('fonds/edit/{id}', [CategoryController::class, 'editFond'])->name('category.editFond')->middleware('auth', 'role:admin');
    Route::put('fonds/update/{id}', [CategoryController::class, 'updateFond'])->name('category.updateFond')->middleware('auth', 'role:admin');
    Route::delete('fonds/{id}', [CategoryController::class, 'destroyFond'])->name('category.destroyFond')->middleware('auth', 'role:admin');

    // Danh Mục Tài Liệu
    Route::get('categories', [CategoryController::class, 'categories'])->name('category.categories')->middleware('auth', 'role:admin');
    Route::get('categories/create', [CategoryController::class, 'createCategory'])->name('category.categories.create')->middleware('auth', 'role:admin');
    Route::post('categories', [CategoryController::class, 'storeCategory'])->name('category.categories.store')->middleware('auth', 'role:admin');
    Route::get('categories/edit/{id}', [CategoryController::class, 'editCategory'])->name('category.editCategory')->middleware('auth', 'role:admin');
    Route::put('categories/update/{id}', [CategoryController::class, 'updateCategory'])->name('category.updateCategory')->middleware('auth', 'role:admin');
    Route::delete('categories/{id}', [CategoryController::class, 'destroyCategory'])->name('category.destroyCategory')->middleware('auth', 'role:admin');

    // Kho Lưu Trữ
    Route::get('warehouses', [CategoryController::class, 'warehouses'])->name('category.warehouses')->middleware('auth', 'role:admin');
    Route::get('warehouses/create', [CategoryController::class, 'createWarehouse'])->name('category.warehouses.create')->middleware('auth', 'role:admin');
    Route::post('warehouses', [CategoryController::class, 'storeWarehouse'])->name('category.warehouses.store')->middleware('auth', 'role:admin');
    Route::get('warehouses/edit/{id}', [CategoryController::class, 'editWarehouse'])->name('category.editWarehouse')->middleware('auth', 'role:admin');
    Route::put('warehouses/update/{id}', [CategoryController::class, 'updateWarehouse'])->name('category.updateWarehouse')->middleware('auth', 'role:admin');
    Route::delete('warehouses/{id}', [CategoryController::class, 'destroyWarehouse'])->name('category.destroyWarehouse')->middleware('auth', 'role:admin');

    // Kệ Trong Kho
    Route::get('shelves', [CategoryController::class, 'shelves'])->name('category.shelves')->middleware('auth', 'role:admin');
    Route::get('shelves/create', [CategoryController::class, 'createShelf'])->name('category.shelves.create')->middleware('auth', 'role:admin');
    Route::post('shelves', [CategoryController::class, 'storeShelf'])->name('category.shelves.store')->middleware('auth', 'role:admin');
    Route::get('shelves/edit/{id}', [CategoryController::class, 'editShelf'])->name('category.editShelf')->middleware('auth', 'role:admin');
    Route::put('shelves/update/{id}', [CategoryController::class, 'updateShelf'])->name('category.updateShelf')->middleware('auth', 'role:admin');
    Route::delete('shelves/{id}', [CategoryController::class, 'destroyShelf'])->name('category.destroyShelf')->middleware('auth', 'role:admin');

    // Hộp trên kệ
    Route::get('boxes', [CategoryController::class, 'boxes'])->name('category.boxes')->middleware('auth', 'role:admin');
    Route::get('boxes/create', [CategoryController::class, 'createBox'])->name('category.boxes.create')->middleware('auth', 'role:admin');
    Route::post('boxes', [CategoryController::class, 'storeBox'])->name('category.boxes.store')->middleware('auth', 'role:admin');
    Route::get('boxes/edit/{id}', [CategoryController::class, 'editBox'])->name('category.editBox')->middleware('auth', 'role:admin');
    Route::put('boxes/update/{id}', [CategoryController::class, 'updateBox'])->name('category.updateBox')->middleware('auth', 'role:admin');
    Route::delete('boxes/{id}', [CategoryController::class, 'destroyBox'])->name('category.destroyBox')->middleware('auth', 'role:admin');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/categories/list', [CategoryController::class, 'userList'])->name('categories.user-list');
});

Route::get('fonds/{id}/records/create', [CategoryController::class, 'createRecord'])->name('category.records.create');
Route::post('fonds/{id}/records', [CategoryController::class, 'storeRecord'])->name('category.records.store');
Route::post('fonds/{id}/records/import', [CategoryController::class, 'importRecords'])->name('category.records.import');




