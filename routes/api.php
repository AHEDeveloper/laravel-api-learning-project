<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProductController;


Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function (){

    Route::apiResource('/products',ProductController::class);
    Route::apiResource('/categorys',CategoryController::class);
    Route::post('/logout',[AuthController::class,'logout']);
    Route::post('/logout-all',[AuthController::class,'logoutWithTokens']);
    Route::post('/logout-specific-token/{tokenId}',[AuthController::class,'logoutSpecificToken']);

});

