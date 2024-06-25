<?php

use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\SupplierController;
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


//Supplier
Route::get('suppliers', [SupplierController::class, 'index']);
Route::post('supplier', [SupplierController::class, 'store']);
Route::put('supplier', [SupplierController::class, 'update']);
Route::delete('supplier/{id}', [SupplierController::class, 'destroy']);


//Product Catergories
Route::get('categories', [ProductCategoryController::class, 'index']);
Route::post('category', [ProductCategoryController::class, 'store']);
Route::put('category', [ProductCategoryController::class, 'update']);
Route::delete('category/{id}', [ProductCategoryController::class, 'destroy']);
