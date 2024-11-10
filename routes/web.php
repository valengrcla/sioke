<?php

use App\Http\Controllers\C_Customer;
use App\Http\Controllers\C_Pengguna;
use App\Http\Controllers\C_Product;
use App\Http\Controllers\C_Sales;
use App\Http\Controllers\C_Poin;
use App\Http\Controllers\C_Auth;
use App\Http\Controllers\C_Dashboard;
use App\Http\Controllers\C_ChangePW;
use App\Http\Controllers\C_Report;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/login', function () {
    return view('welcome');
})->name('login');

Route::get('/changepw', [C_ChangePW::class, 'showChangePasswordForm'])->name('change.password.form');
Route::post('/changepw', [C_ChangePW::class, 'changePassword'])->name('change.password');

Route::get('/login', [C_Auth::class, 'showLoginForm'])->name('login');
Route::post('/login', [C_Auth::class, 'login'])->name('login.process');
Route::middleware('login', 'role:')->group(function () {

        Route::get('/dashboard', [C_Dashboard::class, 'index'])->name('dashboard');

        Route::get('/logout', [C_Auth::class, 'logout'])->name('logout');

        Route::get('/customer', [C_Customer::class, 'index'])->name('customer.index');
        Route::get('/customer/create', [C_Customer::class, 'create'])->name('customer.create'); 
        Route::post('/customer', [C_Customer::class, 'store'])->name('customer.store');
        Route::get('/customer/{id_customer}/edit', [C_Customer::class, 'edit'])->name('customer.edit');
        Route::put('/customer/{id_customer}/update', [C_Customer::class, 'update'])->name('customer.update');
        Route::delete('/customer/{customer}', [C_Customer::class, 'delete'])->name('customer.delete');

        Route::get('/product', [C_Product::class, 'index'])->name('product.index');
        Route::get('/product/create', [C_Product::class, 'create'])->name('product.create'); 
        Route::post('/product', [C_Product::class, 'store'])->name('product.store');
        Route::get('/product/{id_product}/edit', [C_Product::class, 'edit'])->name('product.edit');
        Route::put('/product/{id_product}/update', [C_Product::class, 'update'])->name('product.update');
        Route::delete('/product/{product}', [C_Product::class, 'delete'])->name('product.delete');

        Route::get('/pengguna', [C_Pengguna::class, 'index'])->name('pengguna.index');
        Route::get('/pengguna/create', [C_Pengguna::class, 'create'])->name('pengguna.create'); 
        Route::post('/pengguna', [C_Pengguna::class, 'store'])->name('pengguna.store');
        Route::get('/pengguna/{id_pengguna}/edit', [C_Pengguna::class, 'edit'])->name('pengguna.edit');
        Route::put('/pengguna/{id_pengguna}/update', [C_Pengguna::class, 'update'])->name('pengguna.update');
        Route::delete('/pengguna/{id_pengguna}', [C_Pengguna::class, 'delete'])->name('pengguna.delete');

        Route::get('/sales', [C_Sales::class, 'index'])->name('sales.index');
        Route::get('/sales/create', [C_Sales::class, 'create'])->name('sales.create'); 
        Route::post('/sales/store', [C_Sales::class, 'store'])->name('sales.store');
        Route::get('sales/detail/{id_nota}', [C_Sales::class, 'detail_sales'])->name('sales.detail');

        Route::get('/poin', [C_Poin::class, 'index'])->name('poin.index');
        Route::get('/poin/create', [C_Poin::class, 'create'])->name('poin.penukaran'); 
        Route::get('/poin/{poin}', [C_Poin::class, 'show'])->name('poin.show');

        Route::get('/report', [C_Report::class, 'getReport'])->name('report.index');
        Route::get('/report/export', [C_Report::class, 'exportExcel'])->name('report.export');


});