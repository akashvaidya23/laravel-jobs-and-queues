<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get("/product/upload", [ProductController::class, 'upload_products']);

Route::get("login", function () {
    return view("login");
});

Route::get("signup", function () {
    return view("signup");
});
