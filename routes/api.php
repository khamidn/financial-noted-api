<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API;
use App\Http\Controllers\API\Auth;

Route::post('/login', [Auth\LoginController::class, 'login']);
Route::post('/register', [Auth\RegisterController::class, 'register']);
Route::post('/forgot', [Auth\ForgotPasswordController::class, 'forgot']);
Route::post('/reset', [Auth\ForgotPasswordController::class, 'reset']);

Route::middleware(('auth:api'))->group(function(){
    Route::post('/logout', [Auth\LoginController::class, 'logout']);

    Route::prefix('categories')->name('categories.')->group(function(){
        Route::apiResource('/sub', API\SubCategoryController::class);
        Route::apiResource('/', API\CategoryController::class)->parameters(['' => 'categories']);
    });

    Route::apiResource('/tag', API\TagController::class);
    Route::apiResource('/account', API\AccountController::class);
    Route::apiResource('/transactions', API\TransactionController::class);
    Route::apiResource('/kelola-users', API\UsersController::class); 
});
