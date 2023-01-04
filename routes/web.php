<?php

use Mockery\Generator\Method;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TransactionController;
use App\Models\checkout;

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

Auth::routes();
Route::resource('/product', ProductController::class);
Route::resource('/category', CategoryController::class);
Route::resource('/transaction', TransactionController::class);
Route::resource('/checkout', CheckoutController::class);
Route::get('/chart', [CheckoutController::class, 'chart'])->name('chart');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//example
Route::get('/example', [App\Http\Controllers\ExampleController::class, 'example']);