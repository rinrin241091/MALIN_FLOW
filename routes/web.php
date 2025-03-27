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

Route::get('/', function () {
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

//Đăng ký
Route::get('register', [AuthController::class, 'register'])->name('auth.register');
Route::post('register', [AuthController::class, 'registerStore'])->name('auth.registerStore');

// Profile routes
Route::get('settings', [UserController::class, 'settings'])->name('settings')->middleware('auth');
Route::put('settings/update', [UserController::class, 'updateProfile'])->name('settings.update')->middleware('auth');
Route::put('settings/password', [UserController::class, 'changePassword'])->name('settings.password')->middleware('auth');
Route::post('settings/language', [UserController::class, 'changeLanguage'])->name('settings.language')->middleware('auth');
Route::post('settings/privacy', [UserController::class, 'updatePrivacy'])->name('settings.privacy')->middleware('auth');

//Xóa hàng loạt trong table dashboards
Route::delete('user/bulk-delete', [UserController::class, 'bulkDelete'])->name('user.bulkDelete')->middleware('auth', 'role:admin');