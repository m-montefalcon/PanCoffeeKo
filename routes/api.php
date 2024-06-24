<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//User Accounts
Route::get('users', [UserController::class, 'index']);
Route::post('user/register', [UserController::class, 'register']);
Route::put('user', [UserController::class, 'update']);
Route::delete('user/{userId}', [UserController::class, 'softDelete']);
