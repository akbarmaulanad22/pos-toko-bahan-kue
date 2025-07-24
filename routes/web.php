<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FinancialReportController;
use App\Http\Controllers\FinancialTrackerController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductSizeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StaffController;
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
        // only superadmin, admin can direct this page
        Route::middleware(['notcashieer'])->group(function () {
            Route::get('/dashboard', DashboardController::class)->name('dashboard');

            Route::resource('/roles', RoleController::class)->except(['show']);

            Route::resource('/staffs', StaffController::class);

            Route::resource('/categories', CategoryController::class);

            Route::resource('/products/{product}/sizes', ProductSizeController::class);
            Route::resource('/products', ProductController::class);

            Route::resource('/expenses', ExpenseController::class);

            Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
            Route::patch('/orders/{orderId:int}', [OrderController::class, 'cancel'])->name('orders.cancel');
            Route::put('/orders/{orderId:int}/pay', [OrderController::class, 'pay'])->name('orders.pay');
            Route::patch('/orders/{orderId:int}/{sizeId:int}', [OrderController::class, 'cancelPerItem'])->name('orders.cancelPerItem');

            Route::get('/financial-reports', FinancialReportController::class)->name('financial-reports');

            Route::get('/log/roles', [LogController::class, 'roles'])->name('log.roles');
            Route::get('/log/products', [LogController::class, 'products'])->name('log.products');
            Route::get('/log/staffs', [LogController::class, 'staffs'])->name('log.staffs');
        });

        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{orderId:int}', [OrderController::class, 'show'])->name('orders.show');

        Route::get('/pos', [PosController::class, 'index'])->name('pos.index');

        Route::get('/account', [AccountController::class, 'index'])->name('account.index');
        Route::put('/account/{user}', [AccountController::class, 'update'])->name('account.update');
    });
