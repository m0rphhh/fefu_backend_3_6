<?php

use App\Http\Controllers\NewsWebController;
use App\Http\Controllers\PageWebController;
use App\Http\Controllers\Web\AppealController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pages/{slug}', PageWebController::class);

Route::get('/news', [ NewsWebController::class, 'getAllNews']);
Route::get('/news/{slug}', [ NewsWebController::class, 'getNewsPage']);

Route::get('/appeal', [ AppealController::class, 'show'])->name('appeal.show');
Route::post('/appeal', [ AppealController::class, 'send'])->name('appeal.send');
