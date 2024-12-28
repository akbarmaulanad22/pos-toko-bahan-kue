<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductSizeController;
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

Route::get('/', [MainController::class, 'index'])->name('main.index');
Route::get('/products', [MainController::class, 'showProducts'])->name('main.products');

Route::get('/diaapalahjir/login', [AuthController::class, 'loginPage'])
    ->middleware('guest')
    ->name('login');
Route::post('/diaapalahjir/login', [AuthController::class, 'login'])->middleware('guest');

Route::get('/niggadilarangmasukwak/register', [AuthController::class, 'registrationPage'])
    ->middleware('guest')
    ->name('register');
Route::post('/niggadilarangmasukwak/register', [AuthController::class, 'registration'])->middleware('guest');

Route::post('/idihniggamaukemana/logout', [AuthController::class, 'logout'])
->middleware('auth')
->name('logout');

Route::get('/areaorangpadang/products/ajax', [ProductController::class, 'ajax'])->name('products.ajax');

Route::prefix('areaorangpadang')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        Route::resource('/products/{product}/sizes', ProductSizeController::class);
        Route::resource('/products', ProductController::class);
        Route::resource('/categories', CategoryController::class);

        Route::get('/orders/products/list', [OrderController::class, 'listProducts'])->name('orders.list.products');
        Route::post('/orders/add', [OrderController::class, 'addOrder'])->name('orders.add');
        Route::get('/orders', [OrderController::class, 'index']);
    });
