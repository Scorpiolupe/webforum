<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;



Route::get('/', [PageController::class, 'index'])->name('home');

Route::get('/topics', [PageController::class, 'topics'])->name('topics');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::get('/layout', [CategoryController::class, 'index'])->name('layout');





