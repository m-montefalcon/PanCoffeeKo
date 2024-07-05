<?php

use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionDetailController;
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
Route::get('users/{id}', [UserController::class, 'show']);



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

//Products
Route::get('products', [ProductController::class, 'index']);
Route::post('product', [ProductController::class, 'store']);
Route::put('product', [ProductController::class, 'update']);
Route::delete('product/{$id}', [ProductController::class, 'destroy']);
Route::get('stockin', [ProductController::class , 'stockin']);


//Transactions
Route::post('transaction', [TransactionController::class, 'store']);


//Transaction Details
Route::post('transaction-detail',  [TransactionDetailController::class, 'store'] );