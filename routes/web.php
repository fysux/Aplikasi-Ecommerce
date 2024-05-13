<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\UserController::class, 'index'])->name('home');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('daftar');

// halaman untuk tingkatkan akun ke user_master
Route::get('/master', function () {
    return view('master');
})->name('master');

Route::post('/master', [\App\Http\Controllers\UserMasterController::class, 'index'])->name('upgrade');

Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::get('/upload_barang', function () {
    return view('upload_barang');
})->name('upload_barang');

Route::post('/upload_barang', [\App\Http\Controllers\UserMasterController::class, 'upload'])->name('upload');

Route::get('/beli/{user_id}/{barang_id}', [\App\Http\Controllers\UserController::class, 'beli'])->name('beli');

Route::post('/beli/{user_id}/{barang_id}', [\App\Http\Controllers\UserController::class, 'beli_barang'])->name('beli_barang');

Route::get('/tambahsaldo', [\App\Http\Controllers\UserController::class, 'tambah_uang'])->name('tambah_saldo');

Route::post('/tambahsaldo', [\App\Http\Controllers\UserController::class, 'tambah_saldo'])->name('tambah_uang');

Route::get('/riwayat', [\App\Http\Controllers\UserController::class, 'riwayat'])->name('riwayat');

Route::get('/riwayat/{id}', [\App\Http\Controllers\UserController::class, 'riwayat_detail'])->name('riwayat_detail');