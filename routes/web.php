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
//首頁
Route::get('/', function () {
    return view('welcome');
});

//分帳系統首頁
Route::get('/TrackSpendingSystem', [HomeController::class , 'home'])->name('home');

//新增分帳系統
Route::get('/createTrackSpendingSystem', [HomeController::class , 'createTrackSpendingSystem'])->name('createTrackSpendingSystem');
Route::post('/getEvent', [HomeController::class , 'getEvent'])->name('getEvent');

//註冊
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'getRegisterData']);

//登入
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'getLoginData']);

//登出
Route::post('/logout', [AuthController::class, 'logout']);

