<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
// use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/chooseLogin', [AuthController::class, 'chooseLogin'])->name('chooseLogin');

Route::get('/returnHome', [AuthController::class, 'returnHome'])->name('returnHome');

Route::get('/userLogInForm', [AuthController::class, 'userLogInForm'])->name('userLogInForm');


Route::get('/adminLogInForm', [AuthController::class, 'adminLogInForm'])->name('adminLogInForm');

Route::get('/registerForm', [AuthController::class, 'registerForm'])->name('registerForm');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/adminlogin', [AuthController::class, 'adminlogin'])->name('adminlogin');

Route::post('/registerUser', [AuthController::class, 'registerUser'])->name('registerUser');


use App\Http\Controllers\FacebookController;

Route::get('auth/facebook', [FacebookController::class, 'redirectToFacebook'])->name('facebook.login');

Route::get('auth/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);

use App\Http\Controllers\GoogleController;

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

use App\Http\Controllers\PostController;

Route::get('/posts', [PostController::class, 'index']);

Route::get('/', function () {
    return view('welcome');
})->name('Home');;
Route::get('/continue-as-guest', [AuthController::class, 'continueAsGuest'])->name('guest.continue');
Route::get('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login');

Route::get('/AdminDashboard', [PageController::class, 'AdminDashboard'])->name('AdminDashboard');
