<?php

use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\ProductController;
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

Route::get('/', [AdminLoginController::class, 'index']);
Route::post('/admin_auth', [AdminLoginController::class, 'admin_auth']);

Route::get('/admin_logout', [AdminLoginController::class, 'admin_logout']);

Route::get('/dashboard', [ProductController::class, 'show']);
Route::get('/delete_product/{id}', [ProductController::class, 'destroy']);

Route::get('/add_product', [ProductController::class, 'create']);
Route::post('/add_product', [ProductController::class, 'store']);

Route::get('/edit_product/{id}', [ProductController::class, 'edit']);
Route::post('/edit_product/{id}', [ProductController::class, 'update']);

//=====================================================================