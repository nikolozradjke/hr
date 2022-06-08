<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\IndexController;
use App\Http\Controllers\Dashboard\TimelineController;

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
    return redirect()->route('Candidates');
});

Auth::routes();

    Route::group([
            'middleware' => 'auth',
            'prefix' => 'dashboard'
        ], function () {
        Route::prefix('candidates')->group(function () { 
            Route::get('/', [IndexController::class, 'index'])->name('Candidates');
            Route::get('/add', [IndexController::class, 'create'])->name('createCandidates');
            Route::post('/store', [IndexController::class, 'store'])->name('storeCandidates');
            Route::get('/edit/{id}', [IndexController::class, 'edit'])->name('editCandidates');
            Route::post('/update/{id}', [IndexController::class, 'update'])->name('updateCandidates');
            Route::post('/remove/{id}', [IndexController::class, 'remove'])->name('removeCandidates');

            Route::prefix('timeline')->group(function () {
                Route::post('/store/{id}', [TimelineController::class, 'store'])->name('updateCandidateTimeline');
            });
        });
    });

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
