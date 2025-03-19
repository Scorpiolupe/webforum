<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/topics', [PageController::class, 'topics'])->name('topics');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::get('/panel', [PageController::class, 'panel'])->name('panel');

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/auth', [AuthController::class, 'showLoginForm'])->name('auth');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// YARAK
Route::get('/categories', [CategoryController::class, 'index']);