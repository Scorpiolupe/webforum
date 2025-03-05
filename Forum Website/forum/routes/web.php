<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/categories', [PageController::class, 'categories'])->name('categories');
Route::get('/topics', [PageController::class, 'topics'])->name('topics');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
