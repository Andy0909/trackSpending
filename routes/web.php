<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
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

// 註冊、登入頁
Route::get('/', function () {
    return view('welcome');
});

// 註冊
Route::get('/register', [AuthController::class, 'registerPage'])->name('registerPage');
Route::post('/register', [AuthController::class, 'registerProcess'])->name('registerProcess');

// 登入
Route::get('/login', [AuthController::class, 'loginPage'])->name('loginPage');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('loginProcess');

// 登出
Route::post('/logout', [AuthController::class, 'logout']);

// 新增 event 頁面
Route::get('/createEvent', [HomeController::class , 'createEventPage'])->name('createEventPage');
Route::post('/createEvent', [HomeController::class , 'createEventProcess'])->name('createEventProcess');

// 分帳系統頁面
Route::match(['get', 'post'], '/trackSpending', [HomeController::class, 'trackSpendingPage'])->name('trackSpendingPage');
Route::post('/createItem', [HomeController::class , 'createItemProcess'])->name('createItemProcess');
Route::post('/updateItem', [HomeController::class , 'updateItemProcess'])->name('updateItemProcess');

// github 第三方登入
Route::get('/login/github', [AuthController::class, 'redirectToGithub'])->name('login.github');
Route::get('/login/github/callback', [AuthController::class, 'handleGithubCallback']);

// google 第三方登入
Route::get('/login/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [AuthController::class, 'handleGoogleCallback']);