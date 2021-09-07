<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API;
use App\Http\Controllers\API\Auth;

Route::post('/login', [Auth\LoginController::class, 'login']);
Route::post('/register', [Auth\RegisterController::class, 'register']);

Route::middleware(('auth:api'))->group(function(){
    Route::post('/logout', [Auth\LoginController::class, 'logout']);

    Route::group(['prefix' => 'categories'], function(){
        Route::resource('/', API\CategoryController::class)->except('create', 'show');
        Route::resource('/sub', API\SubCategoryController::class)->except('create', 'show');
    });

    Route::resource('/tag', API\TagController::class)->except('create', 'show');
    Route::resource('/account', API\AccountController::class)->except('create', 'show');
    Route::resource('/transactions', API\TransactionController::class)->except('create', 'show');
   
});
