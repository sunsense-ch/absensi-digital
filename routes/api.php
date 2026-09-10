<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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

// Route bawaan Breeze/Sanctum, dibiarkan tetap ada
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Login TIDAK butuh token (justru untuk MENDAPATKAN token)
Route::post('/login', [AuthController::class, 'login']);

// Route yang butuh token Sanctum (Authorization: Bearer <token>)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
