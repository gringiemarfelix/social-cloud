<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Posts
Route::middleware('auth:sanctum')->post('/posts/like', [ApiController::class, 'like']);
Route::middleware('auth:sanctum')->post('/posts/comments', [ApiController::class, 'comments']);
Route::middleware('auth:sanctum')->post('/posts/comments/submit', [ApiController::class, 'storeComment']);
Route::middleware('auth:sanctum')->post('/posts/comments/delete', [ApiController::class, 'deleteComment']);
Route::middleware('auth:sanctum')->post('/posts/share', [ApiController::class, 'share']);

// Notifications
Route::middleware('auth:sanctum')->post('/notifications/read', [ApiController::class, 'read']);

// Friends
Route::middleware('auth:sanctum')->post('/friends/search', [ApiController::class, 'friendsSearch']);