<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StatementController;
use App\Http\Controllers\StatementFileController;
use Illuminate\Support\Facades\Route;

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

Route::post('login', 'App\Http\Controllers\AuthController@login');

Route::group(['middleware' => ['api']], function () {
    Route::post('/register', [AuthController::class, 'register']);

    Route::group(['middleware' => ['auth:api']], function () {
        Route::apiResource('statements', StatementController::class)->only([
            'store', 'update', 'destroy'
        ]);
    });

    Route::get('statements', [StatementController::class, 'index']);
    Route::get('statements/{statement}', [StatementController::class, 'show']);

    Route::group(['prefix' => 'statement-files'], function () {
        Route::post('/', [StatementFileController::class, 'store']);
        Route::put('/{statementFile}', [StatementFileController::class, 'update']);
        Route::delete('/{statementFile}', [StatementFileController::class, 'delete']);
    });
});
