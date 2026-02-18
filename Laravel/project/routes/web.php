<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerController;
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

Route::get('/add_categories', function () {
    return view('admin.add_categories');
});

Route::get('/manage_categories', function () {
    return view('admin.manage_categories');
});

Route::get('/add_products', function () {
    return view('admin.add_products');
});

Route::get('/manage_products', function () {
    return view('admin.manage_products');
});

Route::get('/manage_contact',[ContactController::class,'show']);

Route::get('/manage_customer',[CustomerController::class,'show']);

Route::get('/manage_cart', function () {
    return view('admin.manage_cart');
});

Route::get('/manage_order', function () {
    return view('admin.manage_order');
});

Route::get('/manage_feedback', function () {
    return view('admin.manage_feedback');
});
