<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $title = 'Beranda';
    return view('pages/index', ['title' => $title]);
});
Route::get('/tentang_kami', function () {
    $title = 'Tentang Kami';
    return view('pages/tentang_kami', ['title' => $title]);
});
Route::get('/pengajuan_layanan', function () {
    $title = 'Pengajuan Layanan';
    return view('pages/pengajuan_layanan', ['title' => $title]);
});
Route::get('/kontak_kami', function () {
    $title = 'Kontak Kami';
    return view('pages/kontak_kami', ['title' => $title]);
});
Route::get('/tracking', function () {
    $title = 'Tracking Pengajuan';
    return view('pages/tracking', ['title' => $title]);
});

Auth::routes(['verify' => true]);
Route::middleware(['auth:web', 'verified'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //akun managemen
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //customers managemen
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::post('/customers/store',  [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/edit/{id}',  [CustomerController::class, 'edit'])->name('customers.edit');
    Route::delete('/customers/delete/{id}',  [CustomerController::class, 'destroy'])->name('customers.delete');
    Route::get('/customers-datatable', [CustomerController::class, 'getCustomersDataTable']);
});
Route::middleware(['auth:web', 'role:Admin'])->group(function () {
    //user managemen
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::post('/users/store',  [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{id}',  [UserController::class, 'edit'])->name('users.edit');
    Route::delete('/users/delete/{id}',  [UserController::class, 'destroy'])->name('users.delete');
    Route::get('/users-datatable', [UserController::class, 'getUsersDataTable']);
});
