<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/topics', [TopicController::class, 'index'])->name('topics');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::get('/panel', [PanelController::class, 'index'])->name('panel');
Route::get('/panel/question-detail', [PanelController::class, 'questionDetail'])->name('panel.questionDetail');

Route::post('/panel/approve-question', [PanelController::class, 'approveQuestion'])->name('panel.approve');
Route::post('/panel/reject-question', [PanelController::class, 'rejectQuestion'])->name('panel.reject');

Route::middleware(['auth'])->group(function () {
    Route::post('/questions/{questionId}/upvote', [VoteController::class, 'upvote'])->name('questions.upvote');
    Route::post('/questions/{questionId}/downvote', [VoteController::class, 'downvote'])->name('questions.downvote');
});

// Auth routes
Route::get('/auth', [AuthController::class, 'showLoginForm'])->name('auth');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/topics', [TopicController::class, 'store'])->name('topics.store');
Route::get('/topics/create', [TopicController::class, 'create'])->name('topics.create');
Route::get('/topics/{question}', [TopicController::class, 'show'])->name('topics.show');
Route::post('/topics/{question}/reply', [TopicController::class, 'reply'])->name('topics.reply')->middleware('auth');
Route::post('/questions/{question}/upvote', [VoteController::class, 'upvote'])->middleware('auth');
Route::post('/questions/{question}/downvote', [VoteController::class, 'downvote'])->middleware('auth');

Route::get('/categories', [CategoryController::class, 'index']);