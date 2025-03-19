<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\PanelController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/topics', [TopicController::class, 'index'])->name('topics');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::get('/panel', [PanelController::class, 'index'])->name('panel')->middleware('auth');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/panel/approve-question', 'PanelController@approveQuestion')->name('panel.approve');
    Route::post('/panel/reject-question', 'PanelController@rejectQuestion')->name('panel.reject');
});

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/auth', [AuthController::class, 'showLoginForm'])->name('auth');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/topics', [TopicController::class, 'store'])->name('topics.store');
Route::get('/topics/create', [TopicController::class, 'create'])->name('topics.create');
Route::get('/topics/{question}', [TopicController::class, 'show'])->name('topics.show');
Route::post('/topics/{question}/reply', [TopicController::class, 'reply'])->name('topics.reply')->middleware('auth');

Route::get('/categories', [CategoryController::class, 'index']);