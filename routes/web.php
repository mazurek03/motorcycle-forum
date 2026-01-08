<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\WorkerController;
use Illuminate\Support\Facades\Route;
use App\Models\Post;

Route::get('/', function () {
    $posts = Post::with(['user', 'category', 'comments.user'])->latest()->take(5)->get();
    return view('welcome', compact('posts'));
});

Route::middleware('auth')->group(function () {
    // Frontend
    Route::get('/dashboard', [PostController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Backend (Pracownik: rola 2, Admin: rola 1)
    Route::middleware(['role:1,2'])->prefix('worker')->name('worker.')->group(function () {
        Route::get('/panel', [WorkerController::class, 'index'])->name('panel');
        Route::post('/users/{user}/ban', [WorkerController::class, 'banUser'])->name('users.ban');
        Route::post('/users/{user}/role', [WorkerController::class, 'changeRole'])->name('users.role');
    });
});

require __DIR__.'/auth.php';