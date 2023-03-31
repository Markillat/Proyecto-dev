<?php

use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkStationController;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\ClientController;
use Laravel\Passport\Http\Controllers\PersonalAccessTokenController;

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
Route::prefix('v1')->group(function () {

    Route::resource('workstations', WorkStationController::class);
    Route::resource('applications', ApplicantController::class);
    Route::resource('users', UserController::class);

    //Routes authorization
    Route::post('/oauth/token', [AccessTokenController::class, 'issueToken'])->middleware(['throttle', 'guest']);

    //Routes client
    Route::get('/oauth/clients', [ClientController::class, 'forUser']);
    Route::post('/oauth/clients', [ClientController::class, 'store']);
    Route::put('/oauth/clients/{client_id}', [ClientController::class, 'update']);
    Route::delete('/oauth/clients/{client_id}', [ClientController::class, 'destroy']);

    //Routes Personal
    Route::post('/oauth/personal-token', [PersonalAccessTokenController::class, 'store']);
    Route::delete('/oauth/personal-token/{token_id}', [PersonalAccessTokenController::class, 'destroy']);
});
