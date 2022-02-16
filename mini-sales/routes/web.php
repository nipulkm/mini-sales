<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;

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
    return redirect('report');
})->middleware(['auth']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard')->middleware(['auth']);

Route::get('/report', [SalesController::class, 'get_report'])->name('report')->middleware(['auth']);

Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice')->middleware(['auth']);

Route::get('/invoice/{id}', [InvoiceController::class, 'show'])->name('invoice_details')->middleware(['auth']);

Route::get('/create-invoice', [SalesController::class, 'index'])->name('create_invoice')->middleware(['auth']);

Route::post('/save-invoice', [SalesController::class, 'store'])->name('save_invoice')->middleware(['auth']);

Route::post('/add-customer', [CustomerController::class, 'store'])->name('add_customer')->middleware(['auth']);

// Admin
Route::get('/add-user', [UserController::class, 'index'])->name('add_user')->middleware(['admin']);

Route::post('/save-user', [UserController::class, 'store'])->name('save_user')->middleware(['admin']);

Route::get('/add-product', [ProductController::class, 'index'])->name('add_product')->middleware(['admin']);

Route::post('/save-product', [ProductController::class, 'store'])->name('save_product')->middleware(['admin']);

// User


require __DIR__.'/auth.php';
