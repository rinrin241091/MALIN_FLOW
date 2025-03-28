<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Controllers\Backend\DocumentController;
use App\Http\Controllers\Backend\CategoryController;
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
Route::get('admin', [AuthController::class, 'index'])->name('auth.admin')->middleware('login');
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');

//Thêm thành viên
Route::get('user/create', [UserController::class, 'create'])->name('user.addUser')->middleware('auth', 'role:admin');
Route::post('user/store', [UserController::class, 'store'])->name('user.store')->middleware('auth', 'role:admin');

//Sửa thành viên
Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit')->middleware('auth', 'role:admin');
Route::put('user/update/{id}', [UserController::class, 'update'])->name('user.update')->middleware('auth', 'role:admin');

//Xóa thành viên
Route::delete('user/{id}', [UserController::class, 'destroy'])->name('user.destroy')->middleware('auth', 'role:admin');


// Profile routes
Route::get('settings', [UserController::class, 'settings'])->name('settings')->middleware('auth');
Route::put('settings/update', [UserController::class, 'updateProfile'])->name('settings.update')->middleware('auth');
Route::put('settings/password', [UserController::class, 'changePassword'])->name('settings.password')->middleware('auth');
Route::post('settings/language', [UserController::class, 'changeLanguage'])->name('settings.language')->middleware('auth');
Route::post('settings/privacy', [UserController::class, 'updatePrivacy'])->name('settings.privacy')->middleware('auth');

//Xóa hàng loạt trong table dashboards
Route::delete('user/bulk-delete', [UserController::class, 'bulkDelete'])->name('user.bulkDelete')->middleware('auth', 'role:admin');


// Route cho danh sách danh mục
Route::get('category/index', [CategoryController::class, 'index'])->name('category.index')->middleware('auth', 'role:admin');

// Route cho trang tạo danh mục mới
Route::get('category/create', [CategoryController::class, 'create'])->name('category.create')->middleware('auth', 'role:admin');
Route::post('category/store', [CategoryController::class, 'store'])->name('category.store')->middleware('auth', 'role:admin');

// Route cho trang chỉnh sửa danh mục
Route::get('category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit')->middleware('auth', 'role:admin');
Route::put('category/{id}', [CategoryController::class, 'update'])->name('category.update')->middleware('auth', 'role:admin');

// Route để xóa danh mục
Route::delete('category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy')->middleware('auth', 'role:admin');


// Route cho danh sách tài liệu
Route::get('document/index', [DocumentController::class, 'index'])->name('document.index')->middleware('auth', 'role:admin');

// Route cho trang tạo tài liệu mới
Route::get('document/create', [DocumentController::class, 'create'])->name('document.create')->middleware('auth', 'role:admin');
Route::post('document/store', [DocumentController::class, 'store'])->name('document.store')->middleware('auth', 'role:admin');

// Route cho trang chỉnh sửa tài liệu
Route::get('document/{id}/edit', [DocumentController::class, 'edit'])->name('document.edit')->middleware('auth', 'role:admin');
Route::put('document/{id}', [DocumentController::class, 'update'])->name('document.update')->middleware('auth', 'role:admin');

// Route để xóa tài liệu
Route::delete('document/{id}', [DocumentController::class, 'destroy'])->name('document.destroy')->middleware('auth', 'role:admin');