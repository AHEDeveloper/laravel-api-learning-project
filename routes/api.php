<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProductController;

Route::apiResource('/products',ProductController::class);
Route::apiResource('/categorys',CategoryController::class)->middleware('auth:sanctum');
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
