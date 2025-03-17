<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomersController;
use App\Http\Controllers\Api\MeetingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::group(['prefix' => '/customers'], function () {
        Route::get('/', [CustomersController::class, 'list']);
        Route::post('/', [CustomersController::class, 'create']);
        Route::get('/{id}', [CustomersController::class, 'read']);
        Route::put('/{id}', [CustomersController::class, 'update']);
    });
    Route::group(['prefix' => '/meetings'], function () {
        Route::get('/', [MeetingsController::class, 'list']);
        Route::post('/', [MeetingsController::class, 'create']);
        Route::get('/{id}', [MeetingsController::class, 'read']);
        Route::put('/{id}', [CustomersController::class, 'update']);
    });
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
