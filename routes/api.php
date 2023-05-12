<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('customers')->group(function () {
    Route::get("getAll", [CustomerController::class, "getAll"]);
    Route::get("{id}", [CustomerController::class, "get"]);
    Route::post("", [CustomerController::class, "store"]);
    Route::put("{id}", [CustomerController::class, "update"]);
    Route::delete("{id}", [CustomerController::class, "delete"]);
});

Route::prefix('products')->group(function () {
    Route::get("getAll", [ProductController::class, "getAll"]);
    Route::get("{id}", [ProductController::class, "get"]);
    Route::post("", [ProductController::class, "store"]);
    Route::put("{id}", [ProductController::class, "update"]);
    Route::delete("{id}", [ProductController::class, "delete"]);
});

Route::prefix('orders')->group(function () {
    Route::get("getAll", [OrderController::class, "getAll"]);
    Route::get("{id}", [OrderController::class, "get"]);
    Route::post("", [OrderController::class, "store"]);
    Route::delete("{id}", [OrderController::class, "delete"]);
});
