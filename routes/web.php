<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $posts = \App\Models\Post::with(['user', 'category', 'comments.user'])->latest()->take(5)->get();
    return view('welcome', compact('posts'));
});

// Główna strona forum (Dashboard)
Route::get('/dashboard', [PostController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Trasy dla profilu użytkownika
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    // Trasy dla postów na forum
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});

require __DIR__.'/auth.php';