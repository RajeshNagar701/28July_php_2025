<?php

use App\Http\Controllers\userController;
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

Route::get('/users',[userController::class,'index']);  // all data
Route::get('/users/{id}',[userController::class,'show']); // single data
Route::get('/search/{key}',[userController::class,'search']);

Route::post('/post_users',[userController::class,'store']); // insert data
Route::post('/update/{id}',[userController::class,'update']); // update
Route::put('/updatestatus/{id}',[userController::class,'updatestatus']); // update

Route::delete('/delete/{id}',[UserController::class,'destroy']); // delete
Route::post('/login',[userController::class,'login']); // login
