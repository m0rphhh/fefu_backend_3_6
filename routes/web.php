<?php

use App\Http\Controllers\NewsWebController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\CatalogController;
use App\Http\Controllers\Web\OAuthController;
use App\Http\Controllers\PageWebController;
use App\Http\Controllers\Web\AppealController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\ProductController;
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

Route::get('/catalog/{slug?}', [ CatalogController::class, 'index'])->name('catalog');
Route::get('/catalog/product/{slug}', [ ProductController::class, 'index'])->name('product');

Route::get('/appeal', [ AppealController::class, 'show'])->name('appeal.show');
Route::post('/appeal', [ AppealController::class, 'send'])->name('appeal.send');

Route::get('/register', [ AuthController::class, 'registerForm'])->middleware('guest')->name('register.form');
Route::post('/register', [ AuthController::class, 'register'])->middleware('guest')->name('register');

Route::post('/logout', [ AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/login', [ AuthController::class, 'loginForm'])->middleware('guest')->name('login.form');
Route::post('/login', [ AuthController::class, 'login'])->middleware('guest')->name('login');

Route::prefix('/oauth')->group(function () {
    Route::get('/{provider}/redirect', [ OAuthController::class, 'redirectToService'])->name('oauth.redirect');
    Route::get('/{provider}/login', [ OAuthController::class, 'login'])->name('oauth.login');
});

Route::get('/cart', CartController::class)->middleware('auth.optional');

Route::get('/profile', [ AuthController::class, 'profile'])->middleware('auth')->name('profile');
