<?php

use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\ItemController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
    
// });
Route::get('/items', [ItemController::class, 'itemApi']);
    Route::get('/clients', [ItemController::class, 'clientApi']);
    Route::get('/managers', [ItemController::class, 'managerApi']);

Route::get('/items', [OrderApiController::class, 'items']); 
Route::get('/items/{item}/details', [OrderApiController::class, 'getItemById']); 
Route::get('/orders', [OrderApiController::class, 'all']); 
Route::get('/order/{order}/details', [OrderApiController::class, 'getOrderById']); 