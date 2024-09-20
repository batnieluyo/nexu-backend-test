<?php

use Illuminate\Support\Facades\Route;

Route::withoutMiddleware(['auth', 'web'])->group(function () {
    Route::apiResource('brands', \App\Http\Controllers\Api\V1\BrandController::class);
    Route::apiResource('brands.models', \App\Http\Controllers\Api\V1\BrandModelController::class);
    Route::apiResource('brands', \App\Http\Controllers\Api\V1\BrandController::class);
});


