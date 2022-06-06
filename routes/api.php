<?php

use App\Http\Controllers\Api\AppealController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\NewsApiController;
use App\Http\Controllers\PageApiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('pages', PageApiController::class)->only([
    'index',
    'show'
]);

Route::apiResource('news', NewsApiController::class)->only([
    'index',
    'show'
]);

Route::apiResource('catalog', CatalogController::class)->only([
    'index',
    'show'
]);

Route::post('/appeal', [ AppealController::class, 'send']);

Route::post('/register', [ AuthController::class, 'register']);
Route::post('/login', [ AuthController::class, 'login']);
Route::post('/logout', [ AuthController::class, 'logout'])->middleware('auth:sanctum');

