<?php

use App\Http\Controllers\C_Customer;
use App\Http\Controllers\C_Pengguna;
use App\Http\Controllers\C_Product;
use App\Http\Controllers\C_Sales;
use App\Http\Controllers\C_Poin;
use App\Http\Controllers\C_Auth;
use App\Http\Controllers\C_Dashboard;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/login', function () {
    return view('welcome');
})->name('login');

Route::get('/login', [C_Auth::class, 'showLoginForm'])->name('login');

Route::post('/login', [C_Auth::class, 'login'])->name('login.process');

Route::middleware('login', 'role:')->group(function () {

        Route::get('/dashboard', [C_Dashboard::class, 'index'])->name('dashboard');

        Route::get('/logout', [C_Auth::class, 'logout'])->name('logout');

        // diakses oleh semua role (owner, manajer, pegawai)
        Route::get('/customer', [C_Customer::class, 'index'])->name('customer.index');
        Route::get('/customer/create', [C_Customer::class, 'create'])->name('customer.create'); 
        Route::get('/customer/{customer}', [C_Customer::class, 'show'])->name('customer.show');
        Route::get('/customer/{customer}/edit', [C_Customer::class, 'edit'])->name('customer.edit');
        // diakses oleh role owner
        Route::delete('/customer/{customer}', [C_Customer::class, 'delete'])->name('customer.delete');

        // diakses oleh role owner, manajer
        Route::get('/product', [C_Product::class, 'index'])->name('product.index');
        Route::get('/product/create', [C_Product::class, 'create'])->name('product.create'); 
        Route::get('/product/{product}', [C_Product::class, 'show'])->name('product.show');
        Route::get('/product/{product}/edit', [C_Product::class, 'edit'])->name('product.edit');
        Route::delete('/product/{product}', [C_Product::class, 'delete'])->name('product.delete');

        // diakses oleh role owner
        Route::get('/pengguna', [C_Pengguna::class, 'index'])->name('pengguna.index');
        Route::get('/pengguna/create', [C_Pengguna::class, 'create'])->name('pengguna.create'); 
        Route::get('/pengguna/{pengguna}', [C_Pengguna::class, 'show'])->name('pengguna.show');
        Route::get('/pengguna/{pengguna}/edit', [C_Pengguna::class, 'edit'])->name('pengguna.edit');
        Route::delete('/pengguna/{pengguna}', [C_Pengguna::class, 'delete'])->name('pengguna.delete');

        // diakses oleh semua role (owner, manajer, pegawai)
        Route::get('/sales', [C_Sales::class, 'index'])->name('sales.index');
        Route::get('/sales/create', [C_Sales::class, 'create'])->name('sales.create'); 
        Route::get('/sales/{sales}', [C_Sales::class, 'show'])->name('sales.show');
        Route::get('sales/detail/{id_nota}', [C_Sales::class, 'detail_sales'])->name('sales.detail');

        // diakses oleh semua role (owner, manajer, pegawai)
        Route::get('/poin', [C_Poin::class, 'index'])->name('poin.index');
        Route::get('/poin/create', [C_Poin::class, 'create'])->name('poin.penukaran'); 
        Route::get('/poin/{poin}', [C_Poin::class, 'show'])->name('poin.show');


});