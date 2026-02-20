<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerController;
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

Route::get('/', function () {
    return view('website.index');
});

Route::get('/index', function () {
    return view('website.index');
});

Route::get('/about', function () {
    return view('website.about');
});

Route::get('/tours', function () {
    return view('website.tours');
});

Route::get('/contact',[ContactController::class,'create']);
Route::post('/ins_contact',[ContactController::class,'store']);

Route::get('/login',[CustomerController::class,'login']);
Route::get('/login_auth',[CustomerController::class,'login_auth']);
Route::get('/user_logout',[CustomerController::class,'user_logout']);

Route::get('/signup',[CustomerController::class,'create']);
Route::post('/signup',[CustomerController::class,'store']);

// =================  admin Routes  =============================================


Route::get('/admin_login',[AdminController::class,'admin_login']);
Route::get('/admin_auth',[AdminController::class,'admin_auth']);
Route::get('/admin_logout',[AdminController::class,'admin_logout']);

Route::get('/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/add_categories',[CategoryController::class,'create']);
Route::post('/add_categories',[CategoryController::class,'store']);

Route::get('/manage_categories',[CategoryController::class,'index']);
Route::get('/delete_categories/{id}',[CategoryController::class,'destroy']);

Route::get('/add_products',[ProductController::class,'create']);
Route::post('/add_products',[ProductController::class,'store']);

Route::get('/manage_products',[ProductController::class,'index']);
Route::get('/delete_products/{id}',[ProductController::class,'destroy']);


Route::get('/manage_contact',[ContactController::class,'show']);
Route::get('/delete_contact/{id}',[ContactController::class,'destroy']);

Route::get('/manage_customer',[CustomerController::class,'show']);
Route::get('/delete_customer/{id}',[CustomerController::class,'destroy']);

