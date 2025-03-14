<?php

use App\Http\Controllers\Api\UserApiController;
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

Route::post('/login', [UserApiController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function() {
    Route::post('/user/profile', [UserApiController::class, 'getUserDetails']);
    Route::post('/logout', [UserApiController::class, 'logout']);
});