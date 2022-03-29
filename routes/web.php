<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\NewsListController;

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

Route::get('/', [NewsListController::class, 'index']);
Route::get('/category/{slug}', [NewsListController::class, 'getNewsByCategory'])->name('getNewsByCategory');
Route::get('/category/{slug_category}/{slug_news}', [NewsListController::class, 'getNews'])->name('getNews');
