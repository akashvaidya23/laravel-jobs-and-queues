<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::middleware(['auth:sanctum'])->group(function () {
Route::resource("product", ProductController::class);
Route::get("/logout", [AuthController::class, "logout"]);
// });
Route::post("/product/search", [ProductController::class, "search"]);
Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);
