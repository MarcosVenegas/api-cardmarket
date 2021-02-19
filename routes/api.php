<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ColectionController;
use App\Http\Controllers\SaleController;
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

Route::prefix('users')->group(function () {

	Route::post('/create',[UserController::class, 'createUser']);
	Route::post('/login',[UserController::class, 'login']);
	Route::post('/resetPassword',[UserController::class, 'resetPassword']);
});

Route::prefix('cards')->group(function () {

	Route::post('/create',[CardController::class, 'createCard']);
});

Route::prefix('colections')->group(function () {

	Route::post('/update',[ColectionController::class, 'updateColection']);
});

Route::prefix('sales')->group(function () {

    Route::post('/createSale',[SaleController::class, 'createSale']);
    Route::get('/list/{cardname}',[SaleController::class, 'cardsList']);
    Route::get('/find/{name}',[SaleController::class, 'cardsFinder']);
});