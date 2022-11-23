<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\NotificationController;

// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing  

// Login
Route::get('/', [UserController::class, 'login'])->middleware('guest');
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');
// Route::post('/login', [UserController::class, 'authenticate'])->middleware('guest');

// Logout
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Register
Route::get('/register', [UserController::class, 'create'])->middleware('guest');
Route::post('/register', [UserController::class, 'store'])->middleware('guest');

// Post
Route::get('/feed', [PostController::class, 'index'])->middleware('auth', 'verified');

Route::post('/posts', [PostController::class, 'store'])->middleware('auth', 'verified');
Route::get('/posts/{post}', [PostController::class, 'show'])->middleware('auth', 'verified');
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->middleware('auth', 'verified');
Route::put('/posts/{post}', [PostController::class, 'update'])->middleware('auth', 'verified');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->middleware('auth', 'verified');

Route::post('/posts/share', [PostController::class, 'share'])->middleware('auth', 'verified');

// Friends
Route::post('/friends/{friend}/add', [FriendController::class, 'store'])->middleware('auth', 'verified');
Route::get('/friends', [FriendController::class, 'index'])->middleware('auth', 'verified');
Route::put('/friends/{friend}/accept', [FriendController::class, 'update'])->middleware('auth', 'verified');
Route::delete('/friends/{friend}/cancel', [FriendController::class, 'destroy'])->name('cancel')->middleware('auth', 'verified');
Route::delete('/friends/{friend}/reject', [FriendController::class, 'destroy'])->name('reject')->middleware('auth', 'verified');
Route::delete('/friends/{friend}/remove', [FriendController::class, 'destroy'])->middleware('auth', 'verified');

Route::get('/friends/pending', [FriendController::class, 'pending'])->middleware('auth', 'verified');
Route::get('/friends/requests', [FriendController::class, 'requests'])->middleware('auth', 'verified');

// View Friend Profile
Route::get('/profile/{user}', [UserController::class, 'profile'])->middleware('auth', 'verified');
Route::get('/profile/{user}/friends', [UserController::class, 'profileFriends'])->middleware('auth', 'verified');

// Profile
Route::get('/profile', [UserController::class, 'profile'])->middleware('auth', 'verified');
Route::put('/profile', [UserController::class, 'update'])->middleware('auth', 'verified');

// Settings
Route::get('/settings', [UserController::class, 'settings'])->middleware('auth', 'verified');
Route::get('/settings/profile', [UserController::class, 'settings'])->middleware('auth', 'verified');
Route::get('/settings/notifications', [UserController::class, 'settingsNotifications'])->middleware('auth', 'verified');
Route::get('/settings/security', [UserController::class, 'settingsSecurity'])->middleware('auth', 'verified');

// Search
Route::get('/search', [SearchController::class, 'index']);
Route::get('/search/users', [SearchController::class, 'users']);
Route::get('/search/posts', [SearchController::class, 'posts']);

// Notifications
Route::get('/notifications', [NotificationController::class, 'index']);