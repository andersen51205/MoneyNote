<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\AccountController;

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
    return view('welcome');
});

// Auth::routes();
Route::get('/register', [RegisterController::class, 'index'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('/login', [LoginController::class, 'index'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/password/forgot', [PasswordController::class, 'forgotForm'])->name('password.forgot.form');
Route::post('/password/forgot', [PasswordController::class, 'sendEmail'])->name('password.send.email');
Route::get('/password/reset/{token}', [PasswordController::class, 'resetForm'])->name('password.reset.form');
Route::post('/password/reset', [PasswordController::class, 'reset'])->name('password.reset');

/**
 * 使用者
 */
Route::middleware(['auth'])->group(function () {
    // 首頁
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // 帳戶管理
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::get('/account/create', [AccountController::class, 'create'])->name('account.create');
    Route::post('/account', [AccountController::class, 'store'])->name('account.store');
    Route::get('/account/{id}/edit', [AccountController::class, 'edit'])->name('account.edit');
    Route::patch('/account/{id}', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/account/{id}', [AccountController::class, 'destroy'])->name('account.destroy');
});
