<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
<<<<<<< Updated upstream
use App\Http\Controllers\CategoryController;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/topics', [PageController::class, 'topics'])->name('topics');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
<<<<<<< HEAD
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
=======

Route::get('/contact.send', [ContactController::class, 'send'])->name('contact.send');

Route::get('/categories/{id}', [CategoryController::class, 'show']);
>>>>>>> 89f46a0de2a5315fafd1047d0e5f9030371c7554
