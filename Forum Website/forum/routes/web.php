<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
<<<<<<< Updated upstream
use App\Http\Controllers\CategoryController;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/categories', [PageController::class, 'categories'])->name('categories');
Route::get('/topics', [PageController::class, 'topics'])->name('topics');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/', [CategoryController::class, 'index'])->name('home');
Route::get('/categories/{id}', [CategoryController::class, 'show']);
=======
use app\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('home');
});
Route::get('categories',[CategoryController::class, 'index']);
Route::get('categories/{id}',[CategoryController::class, 'show']);
>>>>>>> Stashed changes
