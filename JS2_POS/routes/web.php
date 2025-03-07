<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PenjualanController;

Route::get('/', [HomeController::class,'index']);
Route::get('/user/{id}/name/{name}', [UserController::class,'user']);
Route::get('/penjualan', [PenjualanController::class,'penjualan']);
Route::prefix('category')->group(function () {
    Route::get('/food-beverage', [ProductController::class,'food_beverage']);
    Route::get('/beauty-health', [ProductController::class,'beauty_health']);
    Route::get('/home-care', [ProductController::class,'home_care']);
    Route::get('/baby-kid', [ProductController::class,'baby_kid']);
});

