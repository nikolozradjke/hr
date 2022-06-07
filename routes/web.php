<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\IndexController;

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
    return redirect('login');
});

Auth::routes();

    Route::group([
            'middleware' => 'auth',
            'prefix' => 'dashboard'
        ], function () {
        Route::prefix('candidates')->group(function () { 
            Route::get('/', [IndexController::class, 'index'])->name('dashboard');
            Route::get('/add', [IndexController::class, 'create'])->name('createDashboard');
            Route::post('/store', [IndexController::class, 'store'])->name('storeDashboard');
            Route::get('/edit/{id}', [IndexController::class, 'edit'])->name('editDashboard');
            Route::post('/update/{id}', [IndexController::class, 'update'])->name('updateDashboard');
        });
    });

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
