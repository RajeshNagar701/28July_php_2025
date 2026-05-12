<?php

use App\Http\Controllers\ajaxController;
use App\Http\Controllers\customerController;
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

Route::get('/', [ajaxController::class, 'ajax']);
Route::get('/getstate/{id}', [ajaxController::class, 'getstate']);
Route::get('/getcity/{id}', [ajaxController::class, 'getcity']);

Route::get('/search', [customerController::class, 'index']);
Route::get('/getcustomer/{key}', [customerController::class, 'getcustomer']);