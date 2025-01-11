<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\JobController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


//?start//
// ! all routes / api here must be authentcated
Route::group(['middleware' => ['api']], function () {

    Route::prefix('jobs')->group(function () {

        Route::get('/', [JobController::class, 'index']);

        Route::get('/{id}', [JobController::class, 'show']);

        Route::post('/', [JobController::class, 'store']);

        Route::put('/{id}', [JobController::class, 'update']);

        Route::delete('/{id}', [JobController::class, 'destroy']);

        Route::delete('/{id}/force', [JobController::class, 'destroyForced']);

        Route::post('/filters', [JobController::class, 'filter']);

        Route::get('/restore/index', [JobController::class, 'restoreIndex']);

        Route::post('/restore/{id}', [JobController::class, 'restore']);
    });



});
//?end//