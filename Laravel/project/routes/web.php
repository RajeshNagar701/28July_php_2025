<?php

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

Route::get('/contact', function () {
    return view('website.contact');
});

// =================  admin Routes  =============================================


Route::get('/admin-login', function () {
    return view('admin.index');
});

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

Route::get('/manage_contact', function () {
    return view('admin.manage_contact');
});

Route::get('/manage_customer', function () {
    return view('admin.manage_customer');
});

Route::get('/manage_cart', function () {
    return view('admin.manage_cart');
});

Route::get('/manage_order', function () {
    return view('admin.manage_order');
});

Route::get('/manage_feedback', function () {
    return view('admin.manage_feedback');
});
