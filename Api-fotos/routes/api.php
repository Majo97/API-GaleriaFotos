<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollectionController;
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

Route::post('/register', [AuthController::class, 'register' ]);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Rutas protegidas que requieren autenticación
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/add-collection', [CollectionController::class, 'createCollection']);
    Route::patch('/edit-collection/{id}', [CollectionController::class, 'updateCollection']);
    Route::delete('/delete-collection/{id}', [CollectionController::class, 'deleteCollection']);
    Route::get('/public-collections', [CollectionController::class, 'getPublicCollections']);
    Route::get('/private-collections', [CollectionController::class, 'getPrivateCollections']);
  
});

