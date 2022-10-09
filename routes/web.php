<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

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

Route::get('/TrackSpendingSystem', [HomeController::class , 'home'])->name('home');
Route::get('/createTrackSpendingSystem', [HomeController::class , 'createTrackSpendingSystem'])->name('createTrackSpendingSystem');

Route::post('/get_form_data', [HomeController::class , 'getFormData'])->name('getFormData');

//註冊
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'getRegisterData']);

//登入
Route::get('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'getLoginData']);

//登出
Route::post('/logout', [AuthController::class, 'logout']);

