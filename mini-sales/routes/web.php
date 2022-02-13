<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware(['auth']);

Route::get('/report', function () {
    return view('product_stock_report');
})->name('report')->middleware(['auth']);

Route::get('/invoice', function () {
    return view('invoice');
})->name('invoice')->middleware(['auth']);

// Admin
Route::get('/add-user', [UserController::class, 'show'])->name('add_user');

Route::post('/save-user', [UserController::class, 'store'])->name('save_user');

Route::get('/add-product', [ProductController::class, 'show'])->name('add_product');

Route::post('/save-product', [ProductController::class, 'store'])->name('save_product');

// User


require __DIR__.'/auth.php';
