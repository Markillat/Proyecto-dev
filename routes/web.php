<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::namespace('App\Http\Controllers')->group(function () {

    // Login Routes...
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');

    // Logout Routes...
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
});

Auth::routes();

Route::get('/lista-trabajos', [App\Http\Controllers\PanelController::class, 'indexListJobs'])->name('list-jobs');
Route::get('/lista-postulaciones', [App\Http\Controllers\PanelController::class, 'indexListPostulations'])->name('list-postulations');
Route::get('/registro-trabajo', [App\Http\Controllers\PanelController::class, 'indexCreateJobs'])->name('create-job');

