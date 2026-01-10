<?php

use App\Http\Controllers\Api\Admin\ManageUserController;
use App\Http\Controllers\Api\Post\CommentController;
use App\Http\Controllers\Api\Post\LikeController;
use App\Http\Controllers\Api\Post\PostController;
use App\Http\Controllers\Api\Post\ReportController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Routes to user operations
Route::post('/register',[UserController::class,'userRegister']);
Route::post('/mail-verify',[UserController::class,'mailVerify']);
Route::post('/login',[UserController::class,'login']);
Route::post('/logout',[UserController::class,'logout'])->middleware('auth:sanctum');


// Admin Routes
// View Users
Route::middleware(['auth:sanctum','admin'])->get('/admin/users',[ManageUserController::class,'showUsers']);
Route::middleware(['auth:sanctum','admin'])->get('/admin/pending-users',[ManageUserController::class,'showPendingUsers']);

// Manage Users
Route::middleware(['auth:sanctum','admin'])->get('/admin/users/{id}/approve',[ManageUserController::class,'approveUsers']);
Route::middleware(['auth:sanctum','admin'])->get('/admin/users/{id}/delete',[ManageUserController::class,'deleteUsers']);


Route::middleware(['auth:sanctum'])->group(function(){
    // Posts
    Route::apiResource('posts',PostController::class);

    // Likes
    Route::post('/posts/{post}/like', [LikeController::class, 'store']);
    Route::delete('/posts/{post}/like', [LikeController::class, 'destroy']);

    // Comments
    Route::post('/posts/{post}/comments', [CommentController::class, 'store']);
    Route::post('/comments/{comment}/reply', [CommentController::class, 'reply']);

    // Reports
    Route::post('/posts/{post}/report', [ReportController::class, 'store']);
    
    // Post operations
    Route::post('/posts/{id}/approve',[PostController::class,'approve']);
    Route::post('/posts/{id}/submit-report',[PostController::class,'report']);
    Route::post('/posts/{id}/reject',[PostController::class,'reject']);
    Route::get('/pending-posts',[PostController::class,'pendingPosts']);
    Route::post('/post-comment',[PostController::class,'addComment']);
    Route::post('/post-like',[PostController::class,'postLike']);

});


