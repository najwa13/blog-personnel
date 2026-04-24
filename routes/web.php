<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// PARTIE PUBLIQUE 
Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

// PARTIE ADMIN 
Route::middleware(['auth'])->group(function () {
    // On garde la route dashboard de Breeze 
    Route::get('/dashboard', [ArticleController::class, 'dashboard'])->name('admin.dashboard');

    // CRUD Articles
    Route::get('/admin/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/admin/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/admin/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/admin/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/admin/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');

    // Routes de profil (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
