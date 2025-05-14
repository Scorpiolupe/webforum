<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/topics', [TopicController::class, 'index'])->name('topics');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::get('/panel', [PanelController::class, 'index'])->name('panel');
Route::get('/panel/question-detail', [PanelController::class, 'questionDetail'])->name('panel.questionDetail');

Route::post('/panel/approve-question', [PanelController::class, 'approveQuestion'])->name('panel.approve');
Route::post('/panel/reject-question', [PanelController::class, 'rejectQuestion'])->name('panel.reject');
Route::post('/panel/delete-question', [PanelController::class, 'deleteQuestion'])->name('panel.deleteQuestion');
Route::post('/panel/lock-question', [PanelController::class, 'lockQuestion'])->name('panel.lockQuestion');
Route::post('/panel/unlock-question', [PanelController::class, 'unlockQuestion'])->name('panel.unlockQuestion');
Route::get('/panel/user-detail', [PanelController::class, 'userDetail'])->name('panel.userDetail');
Route::post('/panel/user-ban', [PanelController::class, 'banUser'])->name('panel.banUser');
Route::post('/panel/user-unban', [PanelController::class, 'unbanUser'])->name('panel.unbanUser');
Route::post('/panel/user-make-admin', [PanelController::class, 'makeAdmin'])->name('panel.makeAdmin');
Route::post('/panel/user-remove-admin', [PanelController::class, 'removeAdmin'])->name('panel.removeAdmin');
Route::post('/panel/user-delete', [PanelController::class, 'deleteUser'])->name('panel.deleteUser');
Route::get('/panel/contact-detail', [PanelController::class, 'contactDetail'])->name('panel.contactDetail');
Route::post('/panel/contact-delete', [PanelController::class, 'contactDelete'])->name('panel.contactDelete');

Route::middleware(['auth'])->group(function () {
    Route::post('/topics/{topicId}/upvote', [VoteController::class, 'upvote'])->name('topics.upvote');
    Route::post('/topics/{topicId}/downvote', [VoteController::class, 'downvote'])->name('topics.downvote');
});

Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');

// Profile
Route::get('/profile/{userId}', [ProfileController::class, 'index'])->name('profile');

// Auth routes
Route::get('/auth', [AuthController::class, 'showLoginForm'])->name('auth');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/topics', [TopicController::class, 'store'])->name('topics.store');
Route::get('/topics/create', [TopicController::class, 'create'])->name('topics.create');
Route::get('/topics/{question}', [TopicController::class, 'show'])->name('topics.show');
Route::get('/topics/{question}/edit', [TopicController::class, 'edit'])->name('topics.edit');

Route::put('/topics/{question}', [TopicController::class, 'update'])->name('topics.update');
Route::post('/topics/{question}/reply', [TopicController::class, 'reply'])->name('topics.reply')->middleware('auth');

Route::get('/categories', [CategoryController::class, 'index']);