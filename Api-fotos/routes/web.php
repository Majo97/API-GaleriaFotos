<?php

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
    return view('welcome');
});
// Mostrar formulario de restablecimiento de contraseña
Route::get('/reset-password/{token}', 'App\Http\Controllers\ResetPasswordController@showResetForm')
    ->name('password.reset');

// Restablecer contraseña
Route::post('/reset-password', 'App\Http\Controllers\ResetPasswordController@reset')
    ->name('password.update');

