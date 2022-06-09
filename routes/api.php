<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CandidateController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group([
        'middleware' => ['auth:sanctum'],
    ], function () {
        Route::prefix('candidates')->group(function () { 
            Route::get('/', [CandidateController::class, 'index']);
            Route::get('/show', [CandidateController::class, 'show']);
            Route::get('/show-timeline', [CandidateController::class, 'showCandidateTimeline']);
            Route::post('/store', [CandidateController::class, 'store']);
            Route::post('/change-status', [CandidateController::class, 'changeStatus']);
        });
});
